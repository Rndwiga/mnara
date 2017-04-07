@if(isset($activities))
    @foreach($activities as $activity)
        <li>
            <div class="message_wrapper">
                <h4 class="heading">{{$activity->description}}</h4>
                <blockquote class="message">
                    {{$activity->properties}}
                </blockquote>
                <br />
                <p class="url">
                    <span class="fs1 text-info" aria-hidden="true" data-icon=""></span>
                    <a href="#"><i class="fa fa-calendar"></i> {{$activity->created_at}}</a>
                </p>
            </div>
        </li>
    @endforeach
    {{ $activities->links() }}
@endif
