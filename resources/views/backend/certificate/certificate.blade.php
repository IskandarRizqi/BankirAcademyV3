<!DOCTYPE html>
<html lang="en">
<head>
	<title>CERTIFICATE</title>
	<style>
    @page {
        margin: 0; /* Menghilangkan margin kertas agar background penuh ke pinggir */
    }
    body {
        margin: 0;
        padding: 0;
        width: 100%;
        height: 100%;
    }
    body:before {
        content: "";
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        /* Menggunakan cover agar gambar memenuhi layar tanpa distorsi */
        /* Atau use 100% 100% jika ingin dipaksa pas mengikuti rasio kertas */
        background-image: url('{{ public_path($certs->background) }}');
        background-size: 100% 100%; 
        background-repeat: no-repeat;
        background-position: center;
        z-index: -1000;
    }
    .container {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 80%; /* Beri batas lebar konten agar tidak menabrak pinggir background */
        text-align: center;
    }
	.pt {
		font-size: 34px;
		font-weight: bold;
	}
    .title {
        font-size: 32px;
		padding-bottom: 30px;
    }
	.diberikan, .kode {
		font-size: 30px;
	}
    .content {
        font-size: 20px;
    }
</style>
</head>
<body>
	<div class="container">
		<p class="diberikan"><?= $certificate_code; ?><br>Diberikan Kepada:</p>
		<h2 class="title"><?= $name; ?><br>PT <?= $instansi; ?></h2>
		<!-- <h4 class="pt">PT </h4> -->
		<div class="content">
			<?=$contents?>
		</div>

	</div>
</body>
</html>