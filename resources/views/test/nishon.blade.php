@extends('layouts.testLayout.app_test')

@section('content')
<div class="container">
    <div class="nishon-title">
        <h4 style="color: #D176B2;">Создание цели</h4>
        <div class="nishon-steps">
            <button onclick="location.href=''" class="active"><span>1</span></button>
            <button onclick="location.href=''" class="active d-none"><span>1.2</span></button>
            <button onclick="location.href=''" disabled><span>2</span></button>
            <button onclick="location.href=''" disabled><span>3</span></button>
        </div>
    </div>
    @error('code')
        <div class="container">
            <div class="row mt-5 card-error">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body justify-content-between">
                            <p>
                                {{ trans('message.'.$message) }}
                            </p><button id="close">&times;</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @enderror
    <div class="row">
        <form action="" method="POST">

        </form>
    </div>
</div>
@endsection
