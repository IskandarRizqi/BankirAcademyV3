@include("front.layout.head")
@include("front.layout.topbar")
@include(env("CUSTOM_HEADER","front.layout.header"))
@error('error')
{{$message}}
@enderror
<section id="content">
    <div class="single-product">
        <div class="product">
            <div class="row gutter-40">
                <div class="col-md-5">
                    <div class="product-image">
                        <div class="fslider" data-pagi="false" data-arrows="false" data-thumbs="true">
                            <div class="flexslider">
                                <div class="flex-viewport"
                                    style="overflow: hidden; position: relative; height: 688.844px;">
                                    <img src="{{asset('Image/1666859799-PT. Dragon Prima Farma.jpg')}}" alt="">
                                </div>
                            </div>
                        </div>
                        {{-- <div class="sale-flash badge bg-danger p-2">Sale!</div> --}}
                    </div>
                </div>
                {{-- <div class="col-md-5 product-desc">
                </div> --}}

                <div class="col mt-5">
                    <div class="tabs clearfix mb-0 ui-tabs ui-corner-all ui-widget ui-widget-content" id="tab-1">
                        <ul class="tab-nav clearfix ui-tabs-nav ui-corner-all ui-helper-reset ui-helper-clearfix ui-widget-header"
                            role="tablist">
                            <li role="tab" tabindex="0"
                                class="ui-tabs-tab ui-corner-top ui-state-default ui-tab ui-tabs-active ui-state-active"
                                aria-controls="tabs-1" aria-labelledby="ui-id-1" aria-selected="true"
                                aria-expanded="true"><a href="#tabs-1" tabindex="-1" class="ui-tabs-anchor"
                                    id="ui-id-1"><i class="icon-align-justify2"></i><span
                                        class="d-none d-md-inline-block"> Description</span></a></li>
                            <li role="tab" tabindex="-1" class="ui-tabs-tab ui-corner-top ui-state-default ui-tab"
                                aria-controls="tabs-2" aria-labelledby="ui-id-2" aria-selected="false"
                                aria-expanded="false"><a href="#tabs-2" tabindex="-1" class="ui-tabs-anchor"
                                    id="ui-id-2"><i class="icon-info-sign"></i><span class="d-none d-md-inline-block">
                                        Additional Information</span></a></li>
                            <li role="tab" tabindex="-1" class="ui-tabs-tab ui-corner-top ui-state-default ui-tab"
                                aria-controls="tabs-3" aria-labelledby="ui-id-3" aria-selected="false"
                                aria-expanded="false"><a href="#tabs-3" tabindex="-1" class="ui-tabs-anchor"
                                    id="ui-id-3"><i class="icon-star3"></i><span class="d-none d-md-inline-block">
                                        Reviews (2)</span></a></li>
                        </ul>
                        <div class="tab-container">
                            <div class="tab-content clearfix ui-tabs-panel ui-corner-bottom ui-widget-content"
                                id="tabs-1" aria-labelledby="ui-id-1" role="tabpanel" aria-hidden="false" style="">
                                <p>Pink printed dress, woven, round neck with a keyhole and buttoned closure at the
                                    back, sleeveless, concealed zip up at left side seam, belt loops along waist with
                                    slight gathers beneath, brand appliqu?? above left front hem, has an attached
                                    lining.</p>
                                Comes with a white, slim synthetic belt that has a tang clasp.
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
                                                    <div class="comment-author">John Doe<span><a href="#"
                                                                title="Permalink to this comment">April 24, 2021 at
                                                                10:46AM</a></span></div>
                                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quo
                                                        perferendis aliquid tenetur. Aliquid, tempora, sit aliquam
                                                        officiis nihil autem eum at repellendus facilis quaerat
                                                        consequatur commodi laborum saepe non nemo nam maxime quis error
                                                        tempore possimus est quasi reprehenderit fuga!</p>
                                                    <div class="review-comment-ratings">
                                                        <i class="icon-star3"></i>
                                                        <i class="icon-star3"></i>
                                                        <i class="icon-star3"></i>
                                                        <i class="icon-star3"></i>
                                                        <i class="icon-star-half-full"></i>
                                                    </div>
                                                </div>
                                                <div class="clear"></div>
                                            </div>
                                        </li>
                                        <li class="comment even thread-even depth-1" id="li-comment-2">
                                            <div id="comment-2" class="comment-wrap clearfix">
                                                <div class="comment-meta">
                                                    <div class="comment-author vcard">
                                                        <span class="comment-avatar clearfix">
                                                            <img alt="Image"
                                                                src="https://0.gravatar.com/avatar/ad516503a11cd5ca435acc9bb6523536?s=60"
                                                                height="60" width="60"></span>
                                                    </div>
                                                </div>
                                                <div class="comment-content clearfix">
                                                    <div class="comment-author">Mary Jane<span><a href="#"
                                                                title="Permalink to this comment">June 16, 2021 at
                                                                6:00PM</a></span></div>
                                                    <p>Quasi, blanditiis, neque ipsum numquam odit asperiores hic dolor
                                                        necessitatibus libero sequi amet voluptatibus ipsam velit qui
                                                        harum temporibus cum nemo iste aperiam explicabo fuga odio
                                                        ratione sint fugiat consequuntur vitae adipisci delectus eum
                                                        incidunt possimus tenetur excepturi at accusantium quod
                                                        doloremque reprehenderit aut expedita labore error atque?</p>
                                                    <div class="review-comment-ratings">
                                                        <i class="icon-star3"></i>
                                                        <i class="icon-star3"></i>
                                                        <i class="icon-star3"></i>
                                                        <i class="icon-star-empty"></i>
                                                        <i class="icon-star-empty"></i>
                                                    </div>
                                                </div>
                                                <div class="clear"></div>
                                            </div>
                                        </li>
                                    </ol>

                                    <a href="#" data-bs-toggle="modal" data-bs-target="#reviewFormModal"
                                        class="button button-3d m-0 float-end">Add a Review</a>
                                    <div class="modal fade" id="reviewFormModal" tabindex="-1" role="dialog"
                                        aria-labelledby="reviewFormModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title" id="reviewFormModalLabel">Submit a Review
                                                    </h4>
                                                    <button type="button" class="btn-close btn-sm"
                                                        data-bs-dismiss="modal" aria-hidden="true"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form class="row mb-0" id="template-reviewform"
                                                        name="template-reviewform" action="#" method="post">
                                                        <div class="col-6 mb-3">
                                                            <label for="template-reviewform-name">Name
                                                                <small>*</small></label>
                                                            <div class="input-group">
                                                                <div class="input-group-text"><i class="icon-user"></i>
                                                                </div>
                                                                <input type="text" id="template-reviewform-name"
                                                                    name="template-reviewform-name" value=""
                                                                    class="form-control required">
                                                            </div>
                                                        </div>
                                                        <div class="col-6 mb-3">
                                                            <label for="template-reviewform-email">Email
                                                                <small>*</small></label>
                                                            <div class="input-group">
                                                                <div class="input-group-text">@</div>
                                                                <input type="email" id="template-reviewform-email"
                                                                    name="template-reviewform-email" value=""
                                                                    class="required email form-control">
                                                            </div>
                                                        </div>
                                                        <div class="w-100"></div>
                                                        <div class="col-12 mb-3">
                                                            <label for="template-reviewform-rating">Rating</label>
                                                            <select id="template-reviewform-rating"
                                                                name="template-reviewform-rating" class="form-select">
                                                                <option value="">-- Select One --</option>
                                                                <option value="1">1</option>
                                                                <option value="2">2</option>
                                                                <option value="3">3</option>
                                                                <option value="4">4</option>
                                                                <option value="5">5</option>
                                                            </select>
                                                        </div>
                                                        <div class="w-100"></div>
                                                        <div class="col-12 mb-3">
                                                            <label for="template-reviewform-comment">Comment
                                                                <small>*</small></label>
                                                            <textarea class="required form-control"
                                                                id="template-reviewform-comment"
                                                                name="template-reviewform-comment" rows="6"
                                                                cols="30"></textarea>
                                                        </div>
                                                        <div class="col-12">
                                                            <button class="button button-3d m-0" type="submit"
                                                                id="template-reviewform-submit"
                                                                name="template-reviewform-submit" value="submit">Submit
                                                                Review</button>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Close</button>
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
</section>
@include(env("CUSTOM_FOOTER","front.layout.footer"))