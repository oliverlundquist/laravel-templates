<div id="jumbotron-{{ $instance }}">
    <h1 class="title">I'm in the color {{ $settings->color }}!</h1>
</div>
@if ($styles === true)
<style>
    #{{ $widget }}-{{ $instance }} .title { background-color:#0000ff; color: {{ $settings->color }} };
</style>
@endif
