@extends('layouts.app')

@section('title')
Config System links
@endsection

@section('styles')
<link href="{{ asset('css/push-system.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Config</div>
                <div class="card-body">
                    <a href="{{ route('listPushSystem') }}" title="Back">
                        <button class="btn btn-warning"><i aria-hidden="true" class="fa fa-arrow-left"></i> Back</button>
                    </a>
                    <br /> <br />

                    <button class="btn btn-primary mb-3" id="show-modal-push-link"><i aria-hidden="true" class="fa fa-plus">
                        </i> Tạo config lần push
                    </button>
                    <div class="loading">
                        @include('components.pre-loader')
                    </div>
                    <hr>

                    <div class="area-status mb-3">
                        <div class="form-group">
                            <label for="status" class="control-label">Status</label>
                            <select required="required" id="status" name="status" class="form-control">
                                <?php $dataStatus = $configPushRow->status ?? "on" ?>
                                @foreach($status as $type => $value)
                                <option value="{{ $type }}" {{ $type == $dataStatus  ? 'selected' : '' }}>{{ $value ?? "on"}}</option>
                                @endforeach
                            </select>

                        </div>
                        <div class="form-group">
                            <label for="type" class="control-label">Type</label>
                            <input name="type" value="{{ $configPushRow->type ?? 'search' }}" type="text" id="type" class="form-control">
                        </div>
                        <button class="btn btn-primary save-status-link mt-3" type="submit" aria-expanded="true">
                            Save
                        </button>
                    </div>
                    <hr>
                    <div class="accordion" id="accordion-area">
                        @foreach($configData as $pushIndex => $item)
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingOne">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne_{{ $pushIndex }}" aria-expanded="true" aria-controls="collapseOne_{{ $pushIndex }}">
                                    Lần push thứ: {{ $pushIndex }}
                                </button>
                            </h2>

                            <div id="collapseOne_{{ $pushIndex }}" class="accordion-collapse collapse {{ $pushIndex == 0 ? 'show' : '' }}" aria-labelledby="headingOne" data-bs-parent="#accordion-area">
                                <div class="accordion-body" data-item-id="{{ $item->id }}" id="accordion-body-{{ $item->id }}">
                                    <div class="form-group">
                                        <label for="share-input"><strong>Share web (%)</strong></label>
                                        <input id="share-input" type="text" name="share" value="{{ $item->share ?? '' }}" class="form-control">
                                    </div>

                                    @foreach($item->config_links as $label => $links)
                                    <div class="card">
                                        <p class="card-header"><span class="title-link"><strong>{{ strtoupper($label) }}</strong></span></p>
                                        <div class="card-body">
                                            <form>
                                                <div class="form-group">
                                                    <label for="text-link-area"><strong>Links</strong></label>
                                                    <textarea id="text-link-area" class="form-control" name="{{ $label }}" rows="10">{{ implode("\n", $links ?? []) }}</textarea>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    @endforeach
                                    <button class="btn btn-primary btn-sm edit-link-config-push-item" id="edit-link-config-push-item-{{ $item->id }}" data-item-id="{{ $item->id }}"><i aria-hidden="true" class="fa fa-edit">
                                        </i> Save
                                    </button>
                                </div>
                            </div>
                        </div>
                        @endforeach

                        <!-- @foreach($configData as $pushIndex => $item)
                        <div class="accordion" id="accordionExample">
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_{{ $pushIndex }}" aria-expanded="true" aria-controls="collapse_{{ $pushIndex }}">
                                        Lần push thứ: {{ $pushIndex }}
                                    </button>
                                </h2>
                                <div id="collapse_{{ $pushIndex }}" class="accordion-collapse" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <strong>This is the first item's accordion body.</strong> It is shown by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addPushConfig" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-scrollable modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Config lần push</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <h5><label for="only-number-key">Share web(%</label>)</h5>
                    <input id="only-number-key" type="number" min="0" max="100" name="share" class="form-control" required onkeypress="return onlyNumberKey(event)">
                    <div class="error text-danger"></div>
                </div>

                <div id="list_link_push">
                    <div class="link-push" data-index="0">

                        <div class="card">
                            <h5 class="card-header"><span class="title-link">Link Push 1</span></h5>
                            <div class="card-body">
                                <form class="validate-form-link">
                                    <div class="form-group">
                                        <label for="exampleFormControlTextarea1">Links</label>
                                        <textarea class="form-control" name="links" rows="10" required></textarea>
                                        <div class="error text-danger"></div>
                                        <br><br>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="link-push" data-index="1">
                        <div class="card">
                            <h5 class="card-header"><span class="title-link">Link Push 2</span></h5>
                            <div class="card-body">
                                <form class="validate-form-link">

                                    <div class="form-group">
                                        <label for="exampleFormControlTextarea1">Links</label>
                                        <textarea class="form-control" name="links" rows="10" required></textarea>
                                        <div class="error text-danger"></div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <div class="notice-share-web pull-left  mr-auto text-primary"></div>
                <button type="submit" class="btn btn-primary" id="btn_save_config_links">Save</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.21.0/jquery.validate.min.js" integrity="sha512-KFHXdr2oObHKI9w4Hv1XPKc898mE4kgYx58oqsc/JqqdLMDI4YjOLzom+EMlW8HFUd0QfjfAvxSL6sEq/a42fQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="{{ asset('js/config-system-link.js') }}"></script>
@endsection