@extends('layouts.app')

@section('title')
我的通知 
@stop

@section('content')
    <div class="container">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">

                <div class="panel-body">

                    <h3 class="text-center">
                        <span class="glyphicon glyphicon-bell" aria-hidden="true"></span> 我的通知
                    </h3>
                    <hr>

                    @if ($notifications->count())

                        <div class="notification-list">
                            @foreach ($notifications as $notification)
                            <div class="media">
                                <div class="avatar pull-left">
                                    <a href="{{ route('users.show', $notification->data['user_id']) }}">
                                    <img class="media-object img-thumbnail" alt="{{ $notification->data['user_name'] }}" src="{{ $notification->data['user_avatar'] }}"  style="width:48px;height:48px;"/>
                                    </a>
                                </div>

                                <div class="infos">
                                    <div class="media-heading">
                                        <a href="{{ route('users.show', $notification->data['user_id']) }}">{{ $notification->data['user_name'] }}</a>
                                        评论了
                                        <a href="{{ $notification->data['topic_link'] }}">{{ $notification->data['topic_title'] }}</a>

                                        {{-- 回复删除按钮 --}}
                                        <span class="meta pull-right" title="{{ $notification->created_at }}">
                                            <span class="glyphicon glyphicon-clock" aria-hidden="true"></span>
                                            {{ $notification->created_at->diffForHumans() }}
                                        </span>
                                    </div>
                                    <div class="reply-content">
                                        {!! $notification->data['reply_content'] !!}
                                    </div>
                                </div>
                            </div>
                            <hr>
                            @endforeach

                            {!! $notifications->render() !!}
                        </div>

                    @else
                        <div class="empty-block">没有消息通知！</div>
                    @endif

                </div>
            </div>
        </div>
    </div>
@stop