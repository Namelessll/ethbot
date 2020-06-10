<div class="main-menu" style="padding-right: 0 !important;">
    <div class="menu-inner">
        <nav>
            <ul class="metismenu" id="menu">
                <li @if(\Request::route()->getName() == "index") class="active" @endif>
                    <a href="{{route('index')}}" aria-expanded="true"><i class="fa fa-server"></i><span>Server settings</span></a>
                </li>
                <li @if(\Request::route()->getName() == "viewManagement") class="active" @endif>
                    <a href="{{route('viewManagement')}}" aria-expanded="true"><i class="fa fa-cogs"></i><span>Bot management</span></a>
                </li>
                <li @if(\Request::route()->getName() == "viewStatistic") class="active" @endif>
                    <a href="{{route('viewStatistic')}}" aria-expanded="true"><i class="fa fa-list"></i><span>Bot statistic</span></a>
                </li>
{{--                <li @if(\Request::route()->getName() == "viewQuestions") class="active" @endif>--}}
{{--                    <a href="{{route('viewQuestions')}}" aria-expanded="true"><i class="fa fa-question-circle"></i><span>Users questions</span></a>--}}
{{--                </li>--}}
                <li @if(\Request::route()->getName() == "viewMailer") class="active" @endif>
                    <a href="{{route('viewMailer')}}" aria-expanded="true"><i class="fa fa-mail-reply-all"></i><span>Mailer</span></a>
                </li>
                <li @if(\Request::route()->getName() == "viewPayments") class="active" @endif>
                    <a href="{{route('viewPayments')}}" aria-expanded="true"><i class="fa fa-credit-card"></i><span>Payments</span></a>
                </li>
            </ul>
        </nav>
    </div>
</div>
