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
