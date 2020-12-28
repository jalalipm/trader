@if (isset($portfolio_management))
    {!! Form::model($portfolio_management, ['route' => ['admin.portfolio_managements.update',
    $portfolio_management->id], 'method' => 'POST', 'files' => true, 'enctype' => 'multipart/form-data', 'id' =>
    'detail_modal_portfolio_management']) !!}
    {{ Form::hidden('id', $portfolio_management->id) }}

@else
    {!! Form::open(['route' => 'admin.portfolio_managements.store', 'method' => 'POST', 'files' => true, 'enctype' =>
    'multipart/form-data', 'id' => 'detail_modal_portfolio_management']) !!}
@endif

<div class="card-body text-center">
    @if (!isset($portfolio_management) || $portfolio_management->avatar == null || $portfolio_management->avatar == '')
        <button class="btn btn-sm btn-primary rounded-circle" id="btn-avatar" value="0"
            style="margin-top: 120px;margin-left: -50px;height: 30px;width: 30px;padding:0"><i
                class="fa fa-camera"></i></button>
        <input type="file" id="avatar" style="display: none;" onchange="readURL(this);">
        <img src="{{ asset('app-assets/images/avatar1.jpg') }}" class="rounded-circle  height-150" id="image_box"
            style="max-width: 150px; max-height: 150px;" alt="Card image">
    @elseif (isset($portfolio_management))
        <button class="btn btn-sm btn-primary rounded-circle" id="btn-avatar" value="{{ $portfolio_management->id }}"
            style="margin-top: 120px;margin-left: -50px;height: 30px;width: 30px;padding:0"> <i class="fa fa-camera">
            </i>
        </button>
        <input type="file" id="avatar" style="display: none;" onchange="readURL(this);">
        <img src="{{ $portfolio_management->avatar }}" class="rounded-circle height-150" id="image_box"
            style="max-width: 150px; max-height: 150px;" alt="Card image">
    @endif

</div>

<div class="form-group">
    {!! Form::label('title', 'عنوان :') !!}
    {!! Form::text('title', null, ['class' => 'form-control', 'required']) !!}
</div>
{{-- <div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label class="file">
                <input type="file" id="pic_path" name="pic_path" onchange="readURL(this);">
                <span class="file-custom" data-content="Choose file..."></span>
            </label>
        </div>
    </div>
    <div class="col-md-6" style="text-align: left">
        <img src="{{ isset($portfolio_management) ? $portfolio_management->pic_path : '' }}" id="image_box" alt="Submit"
            width="150" height="70">
    </div>

</div> --}}

<div class="form-group">
    {!! Form::label('describtion', 'توضیحات :') !!}
    {!! Form::textarea('describtion', null, ['class' => 'form-control', 'size' => '30x5']) !!}
</div>

{!! Form::close() !!}

<script>
    /********************************************************************************************************/
    document.getElementById('btn-avatar').onclick = function() {
        document.getElementById('avatar').click();
    };

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#image_box')
                    .attr('src', e.target.result)
                    .width(150)
                    .height(150);
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

</script>
