<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $exam->title }} - Bankir Academy</title>
    <link rel="icon" href="{{ asset('bankir-academy-icon.png') }}">
    <style>
        :root {
            --ink: #172033;
            --muted: #687386;
            --line: #e5eaf1;
            --blue: #3157d5;
            --soft: #f5f7fb;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            background: #eef2f7;
            color: var(--ink);
            font-family: Arial, sans-serif;
        }

        a {
            color: inherit;
        }

        .page {
            width: min(760px, calc(100% - 28px));
            margin: 30px auto 60px;
        }

        .header,
        .card {
            border: 1px solid var(--line);
            border-radius: 16px;
            background: #fff;
            box-shadow: 0 12px 35px rgba(33, 48, 79, .06);
        }

        .header {
            padding: 28px;
            background: linear-gradient(135deg, #1f347e, #3157d5);
            color: #fff;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 28px;
            font-size: 13px;
            font-weight: 700;
        }

        .brand img {
            width: 28px;
            height: 28px;
            object-fit: contain;
        }

        .eyebrow {
            margin: 0 0 8px;
            color: #cbd7ff;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: .12em;
            text-transform: uppercase;
        }

        h1 {
            margin: 0;
            font-size: clamp(25px, 5vw, 38px);
            line-height: 1.1;
        }

        .description {
            max-width: 620px;
            margin: 13px 0 0;
            color: #e0e7ff;
            line-height: 1.6;
        }

        .class-name {
            margin: 17px 0 0;
            color: #fff;
            font-size: 13px;
            font-weight: 700;
        }

        .notice {
            margin: 18px 0;
            padding: 13px 15px;
            border-radius: 11px;
            background: #fff8e6;
            color: #795b0d;
            font-size: 13px;
            line-height: 1.5;
        }

        .error {
            margin: 18px 0;
            padding: 13px 15px;
            border-radius: 11px;
            background: #fff0f0;
            color: #a22d35;
            font-size: 13px;
            line-height: 1.5;
        }

        .card {
            margin-top: 18px;
            padding: 24px;
        }

        .card h2 {
            margin: 0 0 18px;
            font-size: 18px;
        }

        .field {
            margin-top: 14px;
        }

        label {
            display: block;
            margin-bottom: 7px;
            font-size: 13px;
            font-weight: 700;
        }

        input[type=text],
        input[type=tel] {
            width: 100%;
            min-height: 46px;
            padding: 10px 12px;
            border: 1px solid #d7deea;
            border-radius: 9px;
            color: var(--ink);
            font: inherit;
            outline: none;
        }

        input:focus {
            border-color: var(--blue);
            box-shadow: 0 0 0 3px rgba(49, 87, 213, .12);
        }

        .question {
            margin-top: 18px;
            padding: 19px;
            /* border: 1px solid var(--line); */
            border-radius: 12px;
            border-style: none;
            /* background: var(--soft); */
        }

        .question-title {
            margin: 0 0 13px;
            font-size: 14px;
            line-height: 1.55;
        }

        .option {
            display: flex;
            gap: 9px;
            align-items: flex-start;
            margin-top: 9px;
            padding: 10px;
            border: 1px solid #e0e5ed;
            border-radius: 8px;
            background: #fff;
            cursor: pointer;
            font-size: 13px;
            font-weight: 400;
            line-height: 1.4;
        }

        .option:hover {
            border-color: var(--blue);
        }

        .option input {
            margin-top: 2px;
            accent-color: var(--blue);
        }

        .number {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 25px;
            height: 25px;
            margin-right: 7px;
            border-radius: 50%;
            background: #dce5ff;
            color: #2846ae;
            font-size: 11px;
            font-weight: 700;
            vertical-align: middle;
        }

        .submit {
            width: 100%;
            min-height: 50px;
            margin-top: 24px;
            border: 0;
            border-radius: 10px;
            background: var(--blue);
            color: #fff;
            font: inherit;
            font-weight: 700;
            cursor: pointer;
        }

        .submit:hover {
            background: #2645b3;
        }

        .privacy {
            margin: 13px 0 0;
            color: var(--muted);
            font-size: 11px;
            line-height: 1.5;
            text-align: center;
        }

        .success {
            padding: 30px 10px;
            text-align: center;
        }

        .success-icon {
            display: grid;
            place-items: center;
            width: 62px;
            height: 62px;
            margin: 0 auto 16px;
            border-radius: 50%;
            background: #dff7e8;
            color: #18864a;
            font-size: 30px;
        }

        .success h2 {
            margin-bottom: 10px;
        }

        .success p {
            margin: 0 auto;
            max-width: 480px;
            color: var(--muted);
            line-height: 1.6;
        }

        .footer {
            margin-top: 20px;
            color: var(--muted);
            font-size: 11px;
            text-align: center;
        }
    </style>
</head>

<body>
    <main class="page">
        <header class="header">
            <div class="brand"><img src="{{ asset('bankir-academy-icon.png') }}" alt=""> Bankir Academy</div>
            <p class="eyebrow">Exam kelas</p>
            <h1>{{ $exam->title }}</h1>
            @if ($exam->description)
                <p class="description">{{ $exam->description }}</p>
            @endif
            <p class="class-name">Kelas: {{ $exam->classData->title }}</p>
        </header>

        @if ($completed)
            <section class="card success">
                <div class="success-icon">&#10003;</div>
                <h2>Jawaban berhasil dikirim</h2>
                <p>Terima kasih sudah mengikuti exam. Hasil penilaian akan diperiksa oleh admin Bankir Academy dan tidak
                    ditampilkan pada halaman ini.</p>
            </section>
        @else
            @if ($errors->any())
                <div class="error">{{ $errors->first() }}</div>
            @else
                <div class="notice">Isi nama dan nomor HP terlebih dahulu, lalu jawab seluruh pertanyaan. Nilai tidak
                    akan langsung ditampilkan setelah pengiriman.</div>
            @endif

            <form class="card" action="{{ route('exam.submit', $exam->public_token) }}" method="POST">
                @csrf
                <h2>Data peserta</h2>
                <div class="field">
                    <label for="name">Nama lengkap</label>
                    <input id="name" name="name" type="text" value="{{ old('name') }}" maxlength="255"
                        required autocomplete="name">
                </div>
                <div class="field">
                    <label for="phone">Nomor HP</label>
                    <input id="phone" name="phone" type="tel" value="{{ old('phone') }}" maxlength="30"
                        required autocomplete="tel" placeholder="Contoh: 081234567890">
                </div>

                <h2 style="margin-top: 28px;">Pertanyaan</h2>
                @foreach ($questions as $index => $question)
                    <fieldset class="question">
                        <legend class="question-title"><span
                                class="number">{{ $index + 1 }}</span>{{ $question['question'] }}</legend>
                        @foreach ($question['options'] as $key => $option)
                            <label class="option">
                                <input type="radio" name="answers[{{ $index }}]" value="{{ $key }}"
                                    {{ old('answers.' . $index) === $key ? 'checked' : '' }} required>
                                <span><strong>{{ $key }}.</strong> {{ $option }}</span>
                            </label>
                        @endforeach
                        @error('answers.' . $index)
                            <small style="display:block;color:#a22d35;margin-top:8px;">{{ $message }}</small>
                        @enderror
                    </fieldset>
                @endforeach

                <button class="submit" type="submit">Kirim Jawaban</button>
                <p class="privacy">Data nama dan nomor HP digunakan untuk keperluan rekap exam kelas.</p>
            </form>
        @endif
        <p class="footer">Bankir Academy</p>
    </main>
</body>

</html>
