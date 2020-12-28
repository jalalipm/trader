<h4 class="form-section"><i class="fa fa-id-card"></i> عکس جلوی کارت ملی</h4>
<div class="row m-0">
    <div class="col-sm-12 col-md-6 p-1" style="position: relative;height:250px;">
        <div class="tz-gallery">
            <a class="lightbox" id="f_national_link"
                href="{{ isset($user_f_national) ? $user_f_national->pic_path : '../../../app-assets/images/logo/logo-dark-lg.png' }}">
                <img src="{{ isset($user_f_national) ? $user_f_national->pic_path : '../../../app-assets/images/logo/logo-dark-lg.png' }}"
                    alt="Bridge" class="f_national_image">
            </a>
        </div>
    </div>
    <div class="col-sm-12 col-md-6 p-1">
        <div class="row skin skin-square">
            <div class="col-md-4 col-sm-12">
                <input type="radio" value="1" name="status_f_national" id="status_f_national_1"
                    {{ isset($user_f_national) && $user_f_national->status == 1 ? 'checked' : '' }}>
                <label for="status_f_national_1">درحال بررسی</label>
            </div>
            <div class="col-md-4 col-sm-12">
                <input type="radio" value="2" name="status_f_national" id="status_f_national_2"
                    {{ isset($user_f_national) && $user_f_national->status == 2 ? 'checked' : '' }}>
                <label for="status_f_national_2">تایید شده</label>
            </div>
            <div class="col-md-4 col-sm-12">
                <input type="radio" value="3" name="status_f_national" id="status_f_national_3"
                    {{ isset($user_f_national) && $user_f_national->status == 3 ? 'checked' : '' }}>
                <label for="status_f_national_3">غیر قابل قبول</label>
            </div>
        </div>
        <div class="form-group mt-2">
            {!! Form::label('comment_f_national', 'توضیحات :') !!}
            {!! Form::textarea('comment_f_national', isset($user_f_national) ? $user_f_national->comment : null,
            ['class' => 'form-control', 'size' => '1x2']) !!}
        </div>
        <div class="custom-file">
            <input type="file" class="custom-file-input" name="f_national" id="f_national" onchange="readURL(this);">
            <label class="custom-file-label" id="f_national_lable" for="f_national">انتخاب
                عکس</label>
        </div>
    </div>
</div>
<h4 class="form-section"><i class="fa fa-id-card"></i> عکس پشت کارت ملی</h4>
<div class="row m-0">
    <div class="col-sm-12 col-md-6 p-1" style="position: relative;height:250px;">
        <div class="tz-gallery">
            <a class="lightbox" id="b_national_link"
                href="{{ isset($user_b_national) ? $user_b_national->pic_path : '../../../app-assets/images/logo/logo-dark-lg.png' }}">
                <img src="{{ isset($user_b_national) ? $user_b_national->pic_path : '../../../app-assets/images/logo/logo-dark-lg.png' }}"
                    class="b_national_image" alt="Park">
            </a>
        </div>
    </div>
    <div class="col-sm-12 col-md-6 p-1">
        <div class="row skin skin-square">
            <div class="col-md-4 col-sm-12">
                <input type="radio" value="1" name="status_b_national" id="status_b_national_1"
                    {{ isset($user_b_national) && $user_b_national->status == 1 ? 'checked' : '' }}>
                <label for="status_b_national_1">درحال بررسی</label>
            </div>
            <div class="col-md-4 col-sm-12">
                <input type="radio" value="2" name="status_b_national" id="status_b_national_2"
                    {{ isset($user_b_national) && $user_b_national->status == 2 ? 'checked' : '' }}>
                <label for="status_b_national_2">تایید شده</label>
            </div>
            <div class="col-md-4 col-sm-12">
                <input type="radio" value="3" name="status_b_national" id="status_b_national_3"
                    {{ isset($user_b_national) && $user_b_national->status == 3 ? 'checked' : '' }}>
                <label for="status_b_national_3">غیر قابل قبول</label>
            </div>
        </div>
        <div class="form-group mt-2">
            {!! Form::label('comment_b_national', 'توضیحات :') !!}
            {!! Form::textarea('comment_b_national', isset($user_b_national) ? $user_b_national->comment : null,
            ['class' => 'form-control', 'size' => '1x2']) !!}
        </div>
        <div class="custom-file">
            <input type="file" class="custom-file-input" name="b_national" id="b_national" onchange="readURL(this);">
            <label class="custom-file-label" id="b_national_lable" for="b_national">انتخاب
                عکس</label>
        </div>
    </div>
</div>
<h4 class="form-section"><i class="fa fa-address-card"></i> عکس صفحه اول
    شناسنامه</h4>
<div class="row m-0">
    <div class="col-sm-12 col-md-6 p-1" style="position: relative;height:250px;">
        <div class="tz-gallery">
            <a class="lightbox" id="f_birth_certificate_link"
                href="{{ isset($user_f_birth_certificate) ? $user_f_birth_certificate->pic_path : '../../../app-assets/images/logo/logo-dark-lg.png' }}">
                <img src="{{ isset($user_f_birth_certificate) ? $user_f_birth_certificate->pic_path : '../../../app-assets/images/logo/logo-dark-lg.png' }}"
                    class="f_birth_certificate_image" alt="Tunnel">
            </a>
        </div>
    </div>
    <div class="col-sm-12 col-md-6 p-1">
        <div class="row skin skin-square">
            <div class="col-md-4 col-sm-12">
                <input type="radio" value="1" name="status_f_birth_certificate" id="status_f_birth_certificate_1"
                    {{ isset($user_f_birth_certificate) && $user_f_birth_certificate->status == 1 ? 'checked' : '' }}>
                <label for="status_f_birth_certificate_1">درحال بررسی</label>
            </div>
            <div class="col-md-4 col-sm-12">
                <input type="radio" value="2" name="status_f_birth_certificate" id="status_f_birth_certificate_2"
                    {{ isset($user_f_birth_certificate) && $user_f_birth_certificate->status == 2 ? 'checked' : '' }}>
                <label for="status_f_birth_certificate_2">تایید شده</label>
            </div>
            <div class="col-md-4 col-sm-12">
                <input type="radio" value="3" name="status_f_birth_certificate" id="status_f_birth_certificate_3"
                    {{ isset($user_f_birth_certificate) && $user_f_birth_certificate->status == 3 ? 'checked' : '' }}>
                <label for="status_f_birth_certificate_3">غیر قابل قبول</label>
            </div>
        </div>
        <div class="form-group mt-2">
            {!! Form::label('comment_f_birth_certificate', 'توضیحات :') !!}
            {!! Form::textarea('comment_f_birth_certificate', isset($user_f_birth_certificate) ?
            $user_f_birth_certificate->comment : null, ['class' => 'form-control', 'size' => '1x2']) !!}
        </div>
        <div class="custom-file">
            <input type="file" class="custom-file-input" name="f_birth_certificate" id="f_birth_certificate"
                onchange="readURL(this);">
            <label class="custom-file-label" id="f_birth_certificate_lable" for="f_birth_certificate">انتخاب
                عکس</label>
        </div>
    </div>
</div>
<h4 class="form-section"><i class="fa fa-address-card"></i> عکس صفحه دوم
    شناسنامه</h4>
<div class="row m-0">
    <div class="col-sm-12 col-md-6 p-1" style="position: relative;height:250px;">
        <div class="tz-gallery">
            <a class="lightbox" id="c_birth_certificate_link"
                href="{{ isset($user_c_birth_certificate) ? $user_c_birth_certificate->pic_path : '../../../app-assets/images/logo/logo-dark-lg.png' }}">
                <img src="{{ isset($user_c_birth_certificate) ? $user_c_birth_certificate->pic_path : '../../../app-assets/images/logo/logo-dark-lg.png' }}"
                    class="c_birth_certificate_image" alt="Tunnel">
            </a>
        </div>
    </div>
    <div class="col-sm-12 col-md-6 p-1">
        <div class="row skin skin-square">
            <div class="col-md-4 col-sm-12">
                <input type="radio" value="1" name="status_c_birth_certificate" id="status_c_birth_certificate_1"
                    {{ isset($user_c_birth_certificate) && $user_c_birth_certificate->status == 1 ? 'checked' : '' }}>
                <label for="status_c_birth_certificate_1">درحال بررسی</label>
            </div>
            <div class="col-md-4 col-sm-12">
                <input type="radio" value="2" name="status_c_birth_certificate" id="status_c_birth_certificate_2"
                    {{ isset($user_c_birth_certificate) && $user_c_birth_certificate->status == 2 ? 'checked' : '' }}>
                <label for="status_c_birth_certificate_2">تایید شده</label>
            </div>
            <div class="col-md-4 col-sm-12">
                <input type="radio" value="3" name="status_c_birth_certificate" id="status_c_birth_certificate_3"
                    {{ isset($user_c_birth_certificate) && $user_c_birth_certificate->status == 3 ? 'checked' : '' }}>
                <label for="status_c_birth_certificate_3">غیر قابل قبول</label>
            </div>
        </div>
        <div class="form-group mt-2">
            {!! Form::label('comment_c_birth_certificate', 'توضیحات :') !!}
            {!! Form::textarea('comment_c_birth_certificate', isset($user_c_birth_certificate) ?
            $user_c_birth_certificate->comment : null, ['class' => 'form-control', 'size' => '3x2']) !!}
        </div>
        <div class="custom-file">
            <input type="file" class="custom-file-input" name="c_birth_certificate" id="c_birth_certificate"
                onchange="readURL(this);">
            <label class="custom-file-label" id="c_birth_certificate_lable" for="c_birth_certificate">انتخاب
                عکس</label>
        </div>
    </div>
</div>
