<div class="modal fade modalwithselect2" id="classVideoModal" role="dialog" aria-labelledby="classVideoModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="classVideoModalLabel">Pricing</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                    onclick="closemodal('#classVideoModal')">
                    <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="feather feather-x">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </button>
            </div>
            <div class="modal-body">
                <h5 class="activeClassTitle text-uppercase">CLASS NAME GOES HERE</h5>
                <form action="/admin/classes/setadditional" id="newClassesForm" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="_method" value="POST" id="hdnClassesMethod">
                    <input type="hidden" name="hdnClassesId" value="0" class="hdnClassesId">

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="">Kelas Terpopuler</label>
                                <select name="video_kelas_terpopuler" id="video_kelas_terpopuler" class="form-control">
                                    <option value="0">Tidak</option>
                                    <option value="1">Ya</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="">Kelas Sebelumnya</label>
                                <select name="video_kelas_sebelumnya" id="video_kelas_sebelumnya" class="form-control">
                                    <option value="0">Tidak</option>
                                    <option value="1">Ya</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="">Video</label>
                                <input type="file" name="video" id="video" class="form-control"
                                    accept="video/mp4,video/x-m4v,video/*">
                            </div>
                            <video width="320" height="240" id="video_preview" controls>
                                {{--
                                <source src="" type="video/mp4"> --}}
                                Your browser does not support the video tag.
                            </video>
                        </div>
                    </div>
                    <span class="btn" data-dismiss="modal" onclick="closemodal('#classVideoModal')"><i
                            class="flaticon-cancel-12"></i> Discard</span>
                    <button type="submit" class="btn btn-primary">Save</button>
                </form>
            </div>
            <div class="modal-footer"></div>
        </div>
    </div>
</div>