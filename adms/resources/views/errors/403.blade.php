@include('common.header')
@include('common.menu')

<!-- Preloader -->
<!-- <div id="preloader" style="display: none;">
    <div id="status" style="display: none;"><i class="fa fa-spinner fa-spin"></i></div>
</div> -->

<section>

    <div class="lockedpanel">
        <div class="locked">
            <i class="fa fa-lock"></i>
        </div>
        <div class="logged">
            <h4>403</h4>
            <small class="text-muted">对不起，你没有权限操作这个页面</small>
        </div>

    </div><!-- lockedpanel -->

</section>

@include('common.footer')