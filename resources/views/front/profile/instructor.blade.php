@include("front.layout.head")
@include("front.layout.topbar")
@include(env("CUSTOM_HEADER","front.layout.header"))
@error('error')
{{$message}}
@enderror
<section id="content">
    <div class="content-wrap">
        <div class="container clearfix">
            <div class="single-product">
                <div class="product">
                    <div class="row gutter-40">
                        <div class="col-md-5">
                            <div class="product-image">
                                <div class="fslider" data-pagi="false" data-arrows="false" data-thumbs="true">
                                    <div class="flexslider">
                                        <div class="flex-viewport"
                                            style="overflow: hidden; position: relative; height: auto;">
                                            <img src="{{asset('Image/'.json_decode($data->picture)->url)}}" alt="">
                                        </div>
                                    </div>
                                </div>
                                {{-- <div class="sale-flash badge bg-danger p-2">Sale!</div> --}}
                            </div>
                        </div>
                        {{-- <div class="col-md-5 product-desc">
                        </div> --}}

                        <div class="col mt-5">
                            <div class="tabs clearfix mb-0 ui-tabs ui-corner-all ui-widget ui-widget-content"
                                id="tab-1">
                                <ul class="tab-nav clearfix ui-tabs-nav ui-corner-all ui-helper-reset ui-helper-clearfix ui-widget-header"
                                    role="tablist">
                                    <li role="tab" tabindex="0"
                                        class="ui-tabs-tab ui-corner-top ui-state-default ui-tab ui-tabs-active ui-state-active"
                                        aria-controls="tabs-1" aria-labelledby="ui-id-1" aria-selected="true"
                                        aria-expanded="true"><a href="#tabs-1" tabindex="-1" class="ui-tabs-anchor"
                                            id="ui-id-1"><i class="icon-align-justify2"></i><span
                                                class="d-none d-md-inline-block"> Description</span></a></li>
                                    <li hidden role="tab" tabindex="-1"
                                        class="ui-tabs-tab ui-corner-top ui-state-default ui-tab" aria-controls="tabs-2"
                                        aria-labelledby="ui-id-2" aria-selected="false" aria-expanded="false"><a
                                            href="#tabs-2" tabindex="-1" class="ui-tabs-anchor" id="ui-id-2"><i
                                                class="icon-info-sign"></i><span class="d-none d-md-inline-block">
                                                Additional Information</span></a></li>
                                    <li role="tab" tabindex="-1"
                                        class="ui-tabs-tab ui-corner-top ui-state-default ui-tab" aria-controls="tabs-3"
                                        aria-labelledby="ui-id-3" aria-selected="false" aria-expanded="false"><a
                                            href="#tabs-3" tabindex="-1" class="ui-tabs-anchor" id="ui-id-3"><i
                                                class="icon-star3"></i><span class="d-none d-md-inline-block">
                                                Reviews ({{count($review)}})</span></a></li>
                                </ul>
                                <div class="tab-container">
                                    <div class="tab-content clearfix ui-tabs-panel ui-corner-bottom ui-widget-content"
                                        id="tabs-1" aria-labelledby="ui-id-1" role="tabpanel" aria-hidden="false"
                                        style="">
                                        {{$data->desc}}
                                    </div>
                                    <div class="tab-content clearfix ui-tabs-panel ui-corner-bottom ui-widget-content"
                                        id="tabs-2" aria-labelledby="ui-id-2" role="tabpanel" aria-hidden="true"
                                        style="display: none;">
                                        <table class="table table-striped table-bordered">
                                            <tbody>
                                                <tr>
                                                    <td>Size</td>
                                                    <td>Small, Medium &amp; Large</td>
                                                </tr>
                                                <tr>
                                                    <td>Color</td>
                                                    <td>Pink &amp; White</td>
                                                </tr>
                                                <tr>
                                                    <td>Waist</td>
                                                    <td>26 cm</td>
                                                </tr>
                                                <tr>
                                                    <td>Length</td>
                                                    <td>40 cm</td>
                                                </tr>
                                                <tr>
                                                    <td>Chest</td>
                                                    <td>33 inches</td>
                                                </tr>
                                                <tr>
                                                    <td>Fabric</td>
                                                    <td>Cotton, Silk &amp; Synthetic</td>
                                                </tr>
                                                <tr>
                                                    <td>Warranty</td>
                                                    <td>3 Months</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="tab-content clearfix ui-tabs-panel ui-corner-bottom ui-widget-content"
                                        id="tabs-3" aria-labelledby="ui-id-3" role="tabpanel" aria-hidden="true"
                                        style="display: none;">
                                        <div id="reviews" class="clearfix">
                                            <ol class="commentlist clearfix">
                                                @foreach ($review as $r)
                                                <li class="comment even thread-even depth-1" id="li-comment-1">
                                                    <div id="comment-1" class="comment-wrap clearfix">
                                                        <div class="comment-meta">
                                                            <div class="comment-author vcard">
                                                                <span class="comment-avatar clearfix">
                                                                    <img alt="Image"
                                                                        src="https://0.gravatar.com/avatar/ad516503a11cd5ca435acc9bb6523536?s=60"
                                                                        height="60" width="60"></span>
                                                            </div>
                                                        </div>
                                                        <div class="comment-content clearfix">
                                                            <div class="comment-author">{{$r->name}}<span><a href="#"
                                                                        title="Permalink to this comment">{{$r->created_at}}</a></span>
                                                            </div>
                                                            {{$r->review_msg}}
                                                            <div class="review-comment-ratings">
                                                                @for ($i=1; $i <= 5; $i++) @if ($i <=$r->review_val)
                                                                    <i class="icon-star3"></i>
                                                                    @else
                                                                    <i class="icon-star-empty"></i>
                                                                    @endif
                                                                    @endfor
                                                            </div>
                                                        </div>
                                                        <div class="clear"></div>
                                                    </div>
                                                </li>

                                                @endforeach
                                            </ol>

                                            {{-- <button data-toggle="modal" data-target="#reviewFormModal"
                                                class="button button-3d m-0 float-end">Add a Review</button> --}}
                                            <div class="modal fade" id="reviewFormModal" tabindex="-1" role="dialog"
                                                aria-labelledby="reviewFormModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title" id="reviewFormModalLabel">Submit a
                                                                Review
                                                            </h4>
                                                            <button type="button" class="btn-close btn-sm"
                                                                data-dismiss="modal" aria-hidden="true">x</button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form class="row mb-0" id="template-reviewform"
                                                                name="template-reviewform" action="/addreviewinstructor"
                                                                method="post">
                                                                @csrf
                                                                <input type="text" name="instructor_id"
                                                                    id="instructor_id" value="{{$data->id}}" hidden>
                                                                <div class="col-12 mb-3">
                                                                    <label
                                                                        for="template-reviewform-rating">Rating</label>
                                                                    <span id="nilai_val" class="ml-1"></span>
                                                                    <input type="range"
                                                                        class="form-range form-control p-0" id="nilai"
                                                                        name="nilai" value="1" min="1" max="5" required>

                                                                </div>
                                                                <div class="w-100"></div>
                                                                <div class="col-12 mb-3">
                                                                    <label for="template-reviewform-comment">Comment
                                                                        <small>*</small></label>
                                                                    <textarea class="required form-control"
                                                                        id="template-reviewform-comment" name="comment"
                                                                        rows="6" cols="30" required></textarea>
                                                                </div>
                                                                @auth
                                                                <div class="col-12">
                                                                    <button class="button button-3d m-0" type="submit"
                                                                        id="template-reviewform-submit"
                                                                        name="template-reviewform-submit"
                                                                        value="submit">Submit
                                                                        Review</button>
                                                                </div>
                                                                @else
                                                                <div class="col-12">
                                                                    <p class="text-danger">Pastikan Sudah Login!</p>
                                                                </div>
                                                                @endauth
                                                            </form>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="w-100"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $('#nilai').change(function() {
            let nilai = $('#nilai').val();
            $('#nilai_val').html(nilai);
        })
    </script>

</section>
@include(env("CUSTOM_FOOTER","front.layout.footer"))
@if (Session::has('error'))
<script>
    iziToast.error({
        title: 'Error',
        message: '<?= Session::get("error") ?>',
        position: 'topRight',
    });
</script>
@endif
@if (Session::has('success'))
<script>
    iziToast.success({
        title: 'Success',
        message: '<?= Session::get("success") ?>',
        position: 'topRight',
    });
</script>
@endif