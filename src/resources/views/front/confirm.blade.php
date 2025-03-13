<!DOCTYPE html>
<html lang="ja">
    @extends('layouts.app') @section('body_contents')

    <body>
        <div class="container mt-5">
            <div class="d-flex justify-content-center">
                <h2>内容確認</h2>
            </div>
            <form action="{{ route('front.store') }}" method="POST">
                @csrf
                <div class="form-group row align-items-center mb-3">
                    <label
                        for="fullname"
                        class="col-sm-2 col-form-label text-center"
                        >氏名<span class="text-danger">※</span></label
                    >
                    <div class="col-sm-4 text-center">
                        {{ $validatedData["fullname"] }}
                        <input
                            type="hidden"
                            name="fullname"
                            value="{{ $validatedData['fullname'] }}"
                        />
                    </div>
                </div>
                {{-- 性別の選択肢を作る --}}
                <div class="form-group row align-items-center mb-3">
                    <label
                        for="gender"
                        class="col-sm-2 col-form-label text-center"
                        >性別<span class="text-danger">※</span></label
                    >
                    <div class="col-sm-4 text-center">
                        {{ $genderLabel }}
                        <input
                            type="hidden"
                            name="gender"
                            value="{{
                                $validatedData["gender"]
                            }}"
                        />
                    </div>
                </div>

                <div class="form-group row align-items-center mb-3">
                    <label
                        for="age_id"
                        class="col-sm-2 col-form-label text-center"
                        >年代<span class="text-danger">※</span></label
                    >
                    <div class="col-sm-4 text-center">
                        {{ $ageLabel }}

                        <input
                            type="hidden"
                            name="age_id"
                            value="{{ $validatedData["age_id"] }}"
                        />
                    </div>
                </div>
                <div class="form-group row align-items-center mb-3">
                    <label
                        for="email"
                        class="col-sm-2 col-form-label text-center"
                        >メールアドレス<span class="text-danger">※</span></label
                    >
                    <div class="col-sm-4 text-center">
                        {{ $validatedData["email"] }}
                        <input
                            type="hidden"
                            name="email"
                            value="{{ $validatedData["email"] }}"
                        />
                    </div>
                </div>
                <div class="form-group row align-items-center mb-3">
                    <label
                        for="is_send_email"
                        class="col-sm-2 col-form-label text-center"
                        >メール送信可否</label
                    >
                    <div class="col-sm-4 text-center">
                        <div class="form-check">
                            {{ $isSendEmailLabel }}
                            <input
                                type="hidden"
                                name="is_send_email"
                                value="{{ $validatedData["is_send_email"] }}"
                            />
                        </div>
                    </div>
                    <div class="form-group row align-items-center mb-3">
                        <label
                            for="feedback"
                            class="col-sm-2 col-form-label text-center"
                            >ご意見</label
                        >
                        <div class="col-sm-4 text-center">
                            {!! nl2br(e($validatedData["feedback"])) !!}
                            <input
                                type="hidden"
                                name="feedback"
                                value="{{ $validatedData["feedback"] }}"
                            />
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-center gap-3">
                    <button
                        type="submit"
                        class="btn btn-primary"
                        name="action"
                        formmethod="POST"
                        formaction="{{ route('front.backToIndex') }}"
                    >
                        再入力
                    </button>
                    <button type="submit" class="btn btn-success">送信</button>
                </div>
            </form>
        </div>
    </body>
    @endsection
</html>
