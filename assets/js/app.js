/* ============================================================
   app.js — اسکریپت‌های مشترک پنل مدیریت چایخانه
   آماده تبدیل به Laravel (asset('js/app.js'))
============================================================= */

/* ------------------------------------------------------------
   ۱) تبدیل اعداد لاتین به فارسی
   - کل متن‌های داخل app-wrapper را پیمایش کرده و 0-9 را به ۰-۹ تبدیل می‌کند
   - برای محتوای داینامیک (template/Ajax) با فراخوانی دوباره روی همان المان کار می‌کند
------------------------------------------------------------- */
(function () {
    const FA_DIGITS = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];

    function toFa(str) {
        return str.replace(/[0-9]/g, d => FA_DIGITS[d]);
    }

    // پیمایش نودهای متنی و فارسی‌سازی ارقام
    window.persianizeDigits = function (root) {
        root = root || document.querySelector('.app-wrapper');
        if (!root) return;

        const walker = document.createTreeWalker(root, NodeFilter.SHOW_TEXT, null);
        let node;
        while ((node = walker.nextNode())) {
            const parentTag = node.parentNode.nodeName;
            if (parentTag === 'SCRIPT' || parentTag === 'STYLE') continue;
            if (/[0-9]/.test(node.nodeValue)) {
                node.nodeValue = toFa(node.nodeValue);
            }
        }
    };

    // اجرای اولیه پس از بارگذاری صفحه
    document.addEventListener('DOMContentLoaded', () => persianizeDigits());
})();


/* ------------------------------------------------------------
   ۲) ساب‌روتر دمو (صفحات داخلی پرسنل/شیفت)
   - showSub: یک صفحه‌ی داخلی را از روی <template> نمایش می‌دهد
   - showList: بازگشت به لیست اصلی
   - در Laravel این جابه‌جایی با Route و View جایگزین می‌شود
   - با کنترل وجود المان‌ها، در صفحاتی که این بخش را ندارند بی‌اثر است
------------------------------------------------------------- */
function showSub(tplId) {
    const pageList = document.getElementById('page-list');
    const subContainer = document.getElementById('subpage-container');
    const tpl = document.getElementById(tplId);
    if (!pageList || !subContainer || !tpl) return;

    subContainer.innerHTML = '';
    subContainer.appendChild(tpl.content.cloneNode(true));
    pageList.style.display = 'none';
    subContainer.style.display = 'block';
    window.scrollTo(0, 0);
    persianizeDigits(subContainer); // فارسی‌سازی اعداد صفحه‌ی جدید
}

function showList() {
    const pageList = document.getElementById('page-list');
    const subContainer = document.getElementById('subpage-container');
    if (!pageList || !subContainer) return;

    subContainer.style.display = 'none';
    subContainer.innerHTML = '';
    pageList.style.display = 'block';
}


/* ------------------------------------------------------------
   ۳) تعامل فرم شیفت
   - toggleBranch: باز/بسته شدن بدنه‌ی شعبه با تیک هدر
   - togglePass: نمایش/مخفی شدن ساعت‌های یک پاس با تیک آن
------------------------------------------------------------- */
function toggleBranch(branchId, checked) {
    const el = document.getElementById(branchId);
    if (el) el.classList.toggle('open', checked);
}

function togglePass(timesId, checked) {
    const el = document.getElementById(timesId);
    if (el) el.classList.toggle('show', checked);
}


/* ------------------------------------------------------------
   ۴) صفحه حضور و غیاب
------------------------------------------------------------- */

/* الف) هشدار ویرایش اطلاعات گذشته
   - اگر شیفت انتخاب‌شده دارای data-past="true" باشد، نوار زرد نمایش داده می‌شود */
function onShiftChange(selectEl) {
    const warning = document.getElementById('pastWarning');
    if (!warning) return;
    const opt = selectEl.options[selectEl.selectedIndex];
    const isPast = opt && opt.dataset.past === 'true';
    warning.classList.toggle('show', isPast);
}

/* ب) ثبت ورود سریع (یک کلیک) با حالت لودینگ
   - اسپینر روی دکمه فعال می‌شود، سپس (شبیه‌سازی پاسخ سرور) ساعت ورود ثبت می‌گردد
   - در Laravel به‌جای setTimeout یک درخواست Ajax قرار می‌گیرد */
function quickCheckIn(btn) {
    if (btn.classList.contains('done')) return;

    const original = btn.innerHTML;
    btn.disabled = true;
    btn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> در حال ثبت...';

    // شبیه‌سازی پاسخ سرور
    setTimeout(() => {
        const card = btn.closest('.att-card');
        const entrySpan = card ? card.querySelector('.entry-time') : null;
        if (entrySpan) {
            entrySpan.classList.remove('not-set');
            entrySpan.innerHTML = '<i class="bi bi-box-arrow-in-left"></i> ورود: ' + currentTime();
        }
        btn.disabled = false;
        btn.classList.add('done');
        btn.innerHTML = '<i class="bi bi-check-lg"></i> ثبت شد';
    }, 1200);
}

/* ساعت جاری به‌صورت HH:MM (برای ثبت سریع) */
function currentTime() {
    const d = new Date();
    const hh = String(d.getHours()).padStart(2, '0');
    const mm = String(d.getMinutes()).padStart(2, '0');
    return hh + ':' + mm;
}

/* ج) مدال عملیات: نمایش/مخفی فیلدهای حضور بر اساس رادیوی انتخاب‌شده
   - با تغییر هر رادیو، کلاس active کارت‌ها و نمایش فیلدهای «ثبت حضور» مدیریت می‌شود */
function onActionTypeChange(radio) {
    // مدیریت هایلایت کارت‌های رادیویی
    document.querySelectorAll('.action-modal .radio-card').forEach(card => {
        card.classList.toggle('active', card.contains(radio) && radio.checked);
    });
    // نمایش فیلدهای حضور فقط برای گزینه‌ی «ثبت حضور»
    const fields = document.getElementById('presentFields');
    if (fields) fields.classList.toggle('show', radio.value === 'present' && radio.checked);
}

/* باز کردن مدال جزئیات و قراردادن نام کارمند در عنوان آن */
function openActionModal(name) {
    const titleEmp = document.getElementById('modalEmpName');
    if (titleEmp) titleEmp.textContent = name;
    const modalEl = document.getElementById('actionModal');
    if (modalEl && window.bootstrap) {
        bootstrap.Modal.getOrCreateInstance(modalEl).show();
    }
}
