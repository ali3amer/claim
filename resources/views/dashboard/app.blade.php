@include('dashboard.header')

        <div class="container-fluid">
          <div class="content mt-2">
{{--            <div class="page-head">--}}
{{--              <h1 class="page-title">Homepage</h1>--}}
{{--              <p class="page-description lead">This Is Description Of Homepage</p>--}}
{{--            </div>--}}
              <router-view :permissions="{{ json_encode(Auth::user()) }}" auth_id="{!! Auth::user()->id !!}" auth_name="{!! Auth::user()->name !!}"></router-view>
              <vue-progress-bar></vue-progress-bar>
          </div>
        </div>
@include('dashboard.footer')
