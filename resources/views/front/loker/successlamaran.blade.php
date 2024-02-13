@include('front.layout.head')
<style>
    .text-center {
        position: absolute;
        display: flex;
        align-items: center;
        justify-content: center;
        height: 0;
        margin: 0;
    }

    /* Extra small devices (phones, 600px and down) */
    @media only screen and (max-width: 600px) {
        .text-center {
            left: 20%;
            top: 50%;
        }
    }

    /* Small devices (portrait tablets and large phones, 600px and up) */
    @media only screen and (min-width: 600px) {
        .text-center {
            left: 50%;
            top: 50%;
        }

    }

    /* Medium devices (landscape tablets, 768px and up) */
    @media only screen and (min-width: 768px) {
        .text-center {
            left: 50%;
            top: 50%;
        }
    }
</style>
<section id="content">
    <img src="/a_perusahaan.jpg" alt="" class="w-100">
    <div class="text-center">
        <div class="d-flex">
            <a href="/profile" class="button button-circle button-3d button-light button-white mr-2">Profile</a>
            <a href="/loker" class="button button-circle button-3d button-aqua">Loker</a>
        </div>
    </div>
</section>