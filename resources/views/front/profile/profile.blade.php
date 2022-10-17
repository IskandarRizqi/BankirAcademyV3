@include("front.layout.head")
@include("front.layout.topbar")
@include("front.layout.header")

<section id="content">
    <div class="content-wrap" style="padding: 24px;">
        <div class="container clearfix">

            <div class="row clearfix">

                <div class="col-md-12">

                    <!-- <img src="images/icons/avatar.jpg" class="alignleft img-circle img-thumbnail my-0" alt="Avatar" style="max-width: 84px;"> -->

                    <div class="heading-block border-0">
                        <h3>YOUR NAME LOGIN</h3>
                        <span>Your Profile Bio</span>
                    </div>

                    <div class="clear"></div>

                    <div class="row clearfix">

                        <div class="col-lg-12">

                            <div class="tabs tabs-alt clearfix" id="tabs-profile">

                                <ul class="tab-nav clearfix">
                                    <li><a href="#tab-feeds"><i class="icon-credit-cards"></i> Billing class</a></li>
                                    <li><a href="#tab-posts"><i class="icon-cog"></i> Setting</a></li>
                                </ul>

                                <div class="tab-container">
                                    <div class="tab-content clearfix" id="tab-feeds">
                                        <div class="table-responsive">
                                            <table id="datatable1" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                                <thead>
                                                    <tr class="text-center">
                                                        <th>No</th>
                                                        <th>Nomor order</th>
                                                        <!-- <th>Jatuh tempo</th> -->
                                                        <th>Produk</th>
                                                        <th>Rincian</th>
                                                        <th>Metode bayar</th>
                                                        <th>Status</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                </thead>

                                                <tbody>
                                                    <tr>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                </tbody>
                                            </table>



                                        </div>

                                    </div>
                                    <div class="tab-content clearfix" id="tab-posts">
                                        <form action="" method="post">
                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <label for="form-control">Nama</label>
                                                    <input type="text" class="form-control" name="name">
                                                </div>
                                                <div class="col-lg-4">
                                                    <label for="form-control">Email</label>
                                                    <input type="text" class="form-control" name="email">
                                                </div>
                                                <div class="col-lg-4">
                                                    <label for="form-control">Password</label>
                                                    <input type="text" class="form-control" name="password">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <label for="form-control">Nama lengkap</label>
                                                    <input type="text" class="form-control" name="nama_lengkap">
                                                </div>
                                                <div class="col-lg-4">
                                                    <label for="form-control">Nomor handphone</label>
                                                    <input type="text" class="form-control" name="nomor_handphone">
                                                </div>
                                                <div class="col-lg-4">
                                                    <label for="form-control">Company</label>
                                                    <input type="text" class="form-control" name="company">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <label for="form-control">Alamat</label>
                                                    <textarea class="form-control" name="alamat"></textarea>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <button class="button button-small" type="submit">Update profile</button>
                                                </div>
                                            </div>
                                        </form>


                                    </div>
                                </div>

                            </div>

                        </div>

                    </div>

                </div>

                <!-- <div class="w-100 line d-block d-md-none"></div> -->
            </div>

        </div>
    </div>
</section><!-- #content end -->

@include("front.layout.footer")

<script>
    $(document).ready(function() {
        $('#destroy').click(function(event) {
            var form = $(this).closest("form");
            event.preventDefault();
            swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                })
                .then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                        Swal.fire(
                            'Deleted!',
                            'Your data has been deleted.',
                            'success'
                        )

                    }
                });
        });
    })
</script>