import './bootstrap';
import 'animate.css';

// IEU JANG NAVBAR
const mobileMenuButton = document.getElementById('mobile-menu-button');
const mobileMenu = document.getElementById('mobile-menu');

if (mobileMenuButton && mobileMenu) {

    mobileMenuButton.addEventListener('click', () => {

        const CekBukaMobileMenu = !mobileMenu.classList.contains('hidden');

        if (!CekBukaMobileMenu) {

            mobileMenu.classList.remove('hidden');

            mobileMenu.classList.add(
                'animate__animated',
                'animate__fadeInDown'
            );

            mobileMenuButton.setAttribute('aria-expanded', 'true');

        } else {

            mobileMenu.classList.add('hidden');

            mobileMenuButton.setAttribute('aria-expanded', 'false');

        }

    });

}

// IEU JANG MODAL DATA MANAGEMENT 
const dataButton = document.getElementById('data-button');
const dataModal = document.getElementById('data-modal');

const closeDataModal = document.getElementById('close-data-modal');

const passwordStep = document.getElementById('password-step');
const loadingStep = document.getElementById('loading-step');
const dataSelectionStep = document.getElementById('data-selection-step');

const passwordInput = document.getElementById('data-password');
const passwordEnterButton = document.getElementById('password-enter-button');
const passwordError = document.getElementById('password-error');

const dataBukuButton = document.getElementById('data-buku-button');
const dataAnggotaButton = document.getElementById('data-anggota-button');
const dataPeminjamanButton = document.getElementById('data-peminjaman-button');
const dataLaporanButton = document.getElementById('data-laporan-button');


if (
    dataButton &&
    dataModal &&
    closeDataModal &&
    passwordStep &&
    loadingStep &&
    dataSelectionStep &&
    passwordInput &&
    passwordEnterButton &&
    passwordError
) {

    function resetDataModal() {
        passwordStep.classList.remove('hidden');
        loadingStep.classList.add('hidden');
        dataSelectionStep.classList.add('hidden');

        passwordInput.value = '';

        passwordError.classList.add('hidden');

        passwordError.textContent =
            'Password salah.';
    }

    // BUKA MODAL
    dataButton.addEventListener('click', () => {

        resetDataModal();

        dataModal.classList.remove('hidden');
        dataModal.classList.add('flex');

        passwordInput.focus();

    });

    // TUTUP MODAL

    // CARA 1
    closeDataModal.addEventListener('click', () => {

        dataModal.classList.add('hidden');
        dataModal.classList.remove('flex');

        resetDataModal();

    });


    // CARA 2
    dataModal.addEventListener('click', (event) => {

        if (event.target === dataModal) {

            dataModal.classList.add('hidden');
            dataModal.classList.remove('flex');

            resetDataModal();

        }

    });


    // CARA 3
    document.addEventListener('keydown', (event) => {

        if (
            event.key === 'Escape' &&
            !dataModal.classList.contains('hidden')
        ) {

            dataModal.classList.add('hidden');
            dataModal.classList.remove('flex');

            resetDataModal();

        }

    });

    passwordEnterButton.addEventListener('click', async () => {

        const password = passwordInput.value.trim();

        passwordError.classList.add('hidden');

        if (password === '') {

            passwordError.textContent =
                'Password tidak boleh kosong.';

            passwordError.classList.remove('hidden');

            passwordInput.focus();

            return;
        }

        try {

            const csrfToken = document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute('content');


            const kirimkeunPW = await fetch(
                '/admin/data/verify-password',
                {
                    method: 'POST',

                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                    },

                    body: JSON.stringify({
                        password: password,
                    }),
                }
            );


            const hasilna = await kirimkeunPW.json();

            if (!kirimkeunPW.ok) {

                passwordError.textContent =
                    hasilna.message || 'Password salah.';

                passwordError.classList.remove('hidden');

                passwordInput.value = '';
                passwordInput.focus();

                return;
            }

            passwordStep.classList.add('hidden');

            loadingStep.classList.remove('hidden');


            setTimeout(() => {

                loadingStep.classList.add('hidden');

                dataSelectionStep.classList.remove('hidden');

            }, 1500);

        } catch (error) {
            console.error(error);

            passwordError.textContent =
                'Terjadi kesalahan. Silakan coba lagi.';

            passwordError.classList.remove('hidden');
        }

    });

}

if (dataBukuButton) {
    dataBukuButton.addEventListener('click', () => {
        window.location.href = 'data/buku';
    });
}

if (dataAnggotaButton) {
    dataAnggotaButton.addEventListener('click', () => {
        window.location.href = 'data/anggota';
    });
}

if (dataPeminjamanButton) {
    dataPeminjamanButton.addEventListener('click', () => {
        window.location.href = 'data/peminjaman';
    });
}

if (dataLaporanButton) {
    dataLaporanButton.addEventListener('click', () => {
        window.location.href = 'data/laporan';
    });
}


// IEU JANG MODAL DETAIL BUKU
const bookCards = document.querySelectorAll('.book-card');

const bookDetailModal = document.getElementById('book-detail-modal');
const closeBookModal = document.getElementById('close-book-modal');
const closeBookModalBottom = document.getElementById('close-book-modal-bottom');

const modalBookCover = document.getElementById('modal-book-cover');
const modalBookTitle = document.getElementById('modal-book-title');
const modalBookAuthor = document.getElementById('modal-book-author');
const modalBookPublisher = document.getElementById('modal-book-publisher');
const modalBookYear = document.getElementById('modal-book-year');
const modalBookCategory = document.getElementById('modal-book-category');
const modalBookStock = document.getElementById('modal-book-stock');


if (
    bookCards.length > 0 &&
    bookDetailModal &&
    closeBookModal &&
    closeBookModalBottom &&
    modalBookCover &&
    modalBookTitle &&
    modalBookAuthor &&
    modalBookPublisher &&
    modalBookYear &&
    modalBookCategory &&
    modalBookStock
) {

    // IEU JANG MUKA MODAL
    function openBookModal(card) {

        const book = card.dataset;

        modalBookCover.onerror = function () {
            this.onerror = null;
            this.src = '/images/book-placeholder.jpg';
        };

        modalBookCover.src = book.cover;
        modalBookCover.alt = `Cover ${book.judul}`;

        modalBookTitle.textContent = book.judul;
        modalBookAuthor.textContent = book.penulis;
        modalBookPublisher.textContent = book.penerbit;
        modalBookYear.textContent = book.tahun;
        modalBookCategory.textContent = book.kategori;
        modalBookStock.textContent = `Stok: ${book.stok}`;

        bookDetailModal.classList.remove('hidden');
        bookDetailModal.classList.add('flex');

        requestAnimationFrame(() => {

            bookDetailModal.classList.remove('opacity-0');
            bookDetailModal.classList.add('opacity-100');

            const modalContent = document.getElementById(
                'book-detail-content'
            );

            if (modalContent) {
                modalContent.classList.remove(
                    'opacity-0',
                    'translate-y-4',
                    'scale-95'
                );

                modalContent.classList.add(
                    'opacity-100',
                    'translate-y-0',
                    'scale-100'
                );
            }

        });

        document.body.classList.add('overflow-hidden');
    }

    // IEU JANG NUTUP MODAL
    function closeBookDetailModal() {
        const modalContent = document.getElementById(
            'book-detail-content'
        );

        bookDetailModal.classList.remove('opacity-100');
        bookDetailModal.classList.add('opacity-0');

        if (modalContent) {

            modalContent.classList.remove(
                'opacity-100',
                'translate-y-0',
                'scale-100'
            );

            modalContent.classList.add(
                'opacity-0',
                'translate-y-4',
                'scale-95'
            );
        }

        setTimeout(() => {

            bookDetailModal.classList.add('hidden');
            bookDetailModal.classList.remove('flex');

        }, 300);

        document.body.classList.remove('overflow-hidden');
    }

    // IEU JANG SISTEM BUKA MODAL DITERAPKEUN KA SEMUA CARD, SISTEM NA SAMA ANU SEPERTI DI ATAS 
    bookCards.forEach((card) => {

        card.addEventListener('click', () => {
            openBookModal(card);
        });

    });

    // IEU JANG SISTEM TUTUP MODAL DITERAPKEUN KA SEMUA CARD
    // CARA 1
    closeBookModal.addEventListener('click', closeBookDetailModal);
    // CARA 2
    closeBookModalBottom.addEventListener(
        'click',
        closeBookDetailModal
    );
    // CARA 3
    bookDetailModal.addEventListener('click', (event) => {

        if (event.target === bookDetailModal) {
            closeBookDetailModal();
        }

    });
    // CARA 4
    document.addEventListener('keydown', (event) => {

        if (
            event.key === 'Escape' &&
            !bookDetailModal.classList.contains('hidden')
        ) {
            closeBookDetailModal();
        }

    });
}

// IEU JS KHUSUS JANG COVER
document.addEventListener('DOMContentLoaded', function () {

    const coverSources = document.querySelectorAll(
        'input[name="cover_source"]'
    );

    const localField = document.getElementById(
        'cover-local-field'
    );

    const externalField = document.getElementById(
        'cover-external-field'
    );

    const localInput = document.getElementById(
        'cover_file'
    );

    const externalInput = document.getElementById(
        'cover_url'
    );

    // Preview
    const previewContainer = document.getElementById(
        'cover-preview-container'
    );

    const previewImage = document.getElementById(
        'cover-preview'
    );

// IEU JANG NGECEK COVER TERSEDIA ATAU HEUNTEU 
    if (
        coverSources.length === 0 ||
        !localField ||
        !externalField ||
        !localInput ||
        !externalInput ||
        !previewContainer ||
        !previewImage
    ) {
        return;
    }

    // IEU JANG PERUBAHAN COVER
    function updateCoverSource() {
        const selectedSource = document.querySelector(
            'input[name="cover_source"]:checked'
        );

        if (!selectedSource) {
            return;
        }


        // ==============================================
        // LOCAL
        // ==============================================

        if (selectedSource.value === 'local') {

            // Tampilkan input file
            localField.classList.remove('hidden');

            // Sembunyikan input URL
            externalField.classList.add('hidden');

            // Kosongkan URL
            externalInput.value = '';

        }


        // ==============================================
        // EXTERNAL
        // ==============================================

        else {

            // Sembunyikan input file
            localField.classList.add('hidden');

            // Tampilkan input URL
            externalField.classList.remove('hidden');

            // Kosongkan file
            localInput.value = '';

        }
    }

    // IEU JANG PREVIEW FILE ANU DIUPLOAD TINA LOKAL STORAGE
    localInput.addEventListener('change', function () {

        const file = this.files[0];
        if (!file) {

            previewContainer.classList.add('hidden');

            previewImage.src = '';

            return;
        }


        const previewUrl = URL.createObjectURL(file);

        previewImage.src = previewUrl;

        previewContainer.classList.remove('hidden');

    });

    // IEU JANG PREVIEW FILE ANU DIUPLOAD TINA URL EKSTERNAL (GOOGLE)
    externalInput.addEventListener('input', function () {

        const url = this.value.trim();


        if (!url) {

            previewContainer.classList.add('hidden');

            previewImage.src = '';

            return;
        }


        previewImage.src = url;

        previewContainer.classList.remove('hidden');

    });

    // IEU JANG NGARUBAH TYPE INPUTAN PAS SI RADIO DIUBAH
    coverSources.forEach(function (source) {

        source.addEventListener('change', function () {

            updateCoverSource();


            // IEU JANG NGARESET PREVIEW COVER
            previewContainer.classList.add('hidden');

            previewImage.src = '';

        });

    });

    // IEU KODNISI AWAL SI UPADTE SOURCE
    updateCoverSource();

});
