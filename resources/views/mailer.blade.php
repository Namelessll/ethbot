@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 col-md-12 mt-3">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Управление рассылкой</h4>

                    <div class="settings-mail-process" style="display: none;">
                        <div class="alert alert-info" role="alert" style="display: flex; align-items: center;">
                            <div id="floatingCirclesG">
                                <div class="f_circleG" id="frotateG_01"></div>
                                <div class="f_circleG" id="frotateG_02"></div>
                                <div class="f_circleG" id="frotateG_03"></div>
                                <div class="f_circleG" id="frotateG_04"></div>
                                <div class="f_circleG" id="frotateG_05"></div>
                                <div class="f_circleG" id="frotateG_06"></div>
                                <div class="f_circleG" id="frotateG_07"></div>
                                <div class="f_circleG" id="frotateG_08"></div>
                            </div>
                            <div class="text">
                                <p style=" font-size: 13px;"><strong>Внимание!</strong> Началась рассылка сообщения пользователям. Дождитесь окончания выполнения задачи.</p>
                            </div>
                        </div>
                    </div>

                    <div class="settings-mail-success" style="display: none;">
                        <div class="alert alert-success" role="alert" style="display: flex; align-items: center;">
                            <div class="text">
                                <p style=" font-size: 13px;"><strong>Успех!</strong> Рассылка успешно завершена.</p>
                            </div>
                        </div>
                    </div>

                    <form action="{{route('sendMailToUsers')}}" method="POST" id="mail_form" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <textarea class="form-control" id="mail" placeholder="Ваше сообщение..." name="mail" style="resize: none;" cols="15" rows="7" required></textarea>
                        </div>
                        <button type="submit" id="mail_sender" class="btn btn-success mt-2 pr-4 pl-4" style="width: 100%;">Отправить</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
    @push('ajax-mail')
        <script>

            $("#mail_form").submit(function(e) {
                $("#mail_sender").attr('disabled','disabled');
                $(".settings-mail-process").css('display', 'block');
                e.preventDefault(); // avoid to execute the actual submit of the form.

                var form = $(this);
                var url = form.attr('action');

                $.ajax({
                    type: "POST",
                    url: url,
                    data: form.serialize(), // serializes the form's elements.

                    success: function(data)
                    {
                        $(".settings-mail-process").css('display', 'none');
                        $('.settings-mail-success').css('display', 'block');
                    }
                });

            });

        </script>
    @endpush
@endsection
