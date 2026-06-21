<div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title" id="logoutModalLabel">
                    <i class="bi bi-box-arrow-right text-danger"></i> خروج از حساب
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="بستن"></button>
            </div>
            <div class="modal-body text-center py-4">
                <p class="mb-0">آیا می‌خواهید از حساب خود خارج شوید؟</p>
            </div>
            <div class="modal-footer border-0 pt-0 justify-content-center gap-2">
                <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">انصراف</button>
                <form method="POST" action="{{ route('logout') }}" style="display:inline">
                    @csrf
                    <button type="submit" class="btn btn-danger px-4">خروج</button>
                </form>
            </div>
        </div>
    </div>
</div>
