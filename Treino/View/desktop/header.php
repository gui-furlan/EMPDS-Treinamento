<link href='/libs/BaseEmpds/css/base.css' rel="stylesheet">
</link>
<link href='/libs/BaseEmpds/css/modal.css' rel="stylesheet">

<script src='/libs/BaseEmpds/scripts/base.js'></script>
<script src='/libs/BaseEmpds/scripts/menu-lateral.js'></script>
<script src='/libs/BaseEmpds/scripts/modal.js'></script>
<script src='/libs/BaseEmpds/scripts/track.js'></script>
<script src='/libs/BaseEmpds/scripts/url.js'></script>
<script src='/libs/BaseEmpds/scripts/auth.js'></script>
<script src='/libs/BaseEmpds/scripts/var.js'></script>
<script src='/libs/BaseEmpds/scripts/user.js'></script>

<script>
  udev.menu = new MenuLateral();
  udev.track = initTrackManager();
  udev.url = initUrlManager(<?= json_encode($GLOBALS['url']->getSegments(0)) ?>)
  udev.user = initUserManager(<?= json_encode($user) ?>);
</script>