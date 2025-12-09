<style>
    .header-ss {
        background: linear-gradient(to right, #a9c6df, #5c8bb5);
        color: #000;
        padding: 10px 15px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-radius: 5px 5px 0 0;
        flex-wrap: wrap; /* agar item bisa turun */
        gap: 10px;
        margin-bottom: 10px;
    }

    /* Logo kiri */
    .header-ss .logo {
        display: flex;
        align-items: center;
        font-weight: bold;
        font-size: 14px;
        flex: 1 1 auto;
        min-width: 200px;
    }

    .header-ss .logo img {
        height: 35px;
        margin-right: 8px;
    }

    /* Judul tengah */
    .header-ss h1 {
        font-size: 18px;
        font-weight: 900;
        margin: 0 auto;
        text-align: center;
        flex: 2 1 300px;
    }

    /* Bagian kanan */
    .header-ss .right-section {
        display: flex;
        align-items: center;
        gap: 8px;
        flex: 1 1 auto;
        justify-content: flex-end;
        min-width: 150px;
    }

    .header-ss .date {
        background: yellow;
        color: black;
        font-size: 12px;
        font-weight: bold;
        padding: 4px 6px;
        border-radius: 3px;
        white-space: nowrap;
    }

    .header-ss .download {
        font-size: 18px;
        cursor: pointer;
        color: white;
    }

</style>
<div class="header-ss">
    <!-- Kiri: Logo + Nama Komite -->
    <div class="logo">
        <img src="{{ asset('image/ajilogo.png') }}" alt="Logo AJI">
        Komite Inovasi PT. Astra Juoku Indonesia
    </div>

    <!-- Tengah: Judul -->
    <h1>SUGGESTION SYSTEM PORTAL</h1>

    <!-- Kanan: Tanggal + Icon Download -->
    <div class="right-section">
        <div class="date">{{ date('d/m/Y H:i:s') }}</div>
        <div class="download">
            <i class="fa fa-download"></i>
        </div>
    </div>
</div>
