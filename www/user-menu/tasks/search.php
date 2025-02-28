<?php
session_start();

/*echo "<pre>";
print_r($_SESSION);
echo "</pre>";
*/

date_default_timezone_set("Asia/Bangkok");

if (isset($_REQUEST['section'])) {
  $menu_onmouseover = "style=\"background-color: #DDECF0; color: rgb(2, 87, 120);  font-weight:bold;\"";
  $section = array(0, 1, 2, 3, 4, '4.1', 5, 6, 7, 8, 9, 10, 11, 12, 13);
  $section[$_REQUEST['section']] = $menu_onmouseover;
}

if (!isset($_SESSION['username'])) {
  echo "<script language=\"javascript\">location.href='../../';</script>";
}
$disable_flag = "";
?>
<!DOCTYPE HTML
  PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3c.org/TR/1999/REC-html401-19991224/loose.dtd">
<HTML xmlns="http://www.w3.org/1999/xhtml">
<!-- InstanceBegin template="/Templates/user.dwt.php" codeOutsideHTMLIsLocked="true" -->

<HEAD>
  <!-- InstanceBeginEditable name="doctitle" -->
  <TITLE>Web Portal :: Operation and Research Section</TITLE>
  <!-- InstanceEndEditable -->
  <META http-equiv=Content-Type content="text/html; charset=utf-8">
  <META content="tsunami, experiment, simulation, visualization, web portal, grid, cluster" name=description>
  <META content="index, follow" name=robots>
  <link type="text/css" rel="stylesheet" href="../../style/forum.css">
  <LINK href="../../style/style.css?<?php echo time(); ?>" type=text/css rel=stylesheet>
  <LINK href="../../style/column.css" type=text/css rel=stylesheet>
  <link href="../../style/expr.css" type="text/css" rel="stylesheet">
  <SCRIPT src="../../script/mainscript.js" type=text/javascript></SCRIPT>
  <script src="../../script/jquery-3.3.1.min.js" type="text/javascript"></script>
  <script language="javascript">
    $(document).ready(function() {
      $("#select-case").change(function() {
        var case_pagination_url = $('option:selected', this).attr('data-url');
        window.location.replace(case_pagination_url);
      });
    });

    function confirm_del_vis(name, id) {
      if (confirm('Do you really want to delete `' + name + '` ?')) {
        document.location.href = '../library/delete-vis.php?id=' + id;
      } else
        return;
    }

    function swap_pane() {
      if (sim_pane.style.display == '')
        alert('sim_pane is openned');
      else
        alert('test');
    }

    /**
     * @param {"tmd" | "usgs" | "geofon"} provider
     */
    function filterLatLong(items, provider) {
      const minLat = -5;
      const maxLat = 25;
      const minLong = 87;
      const maxLong = 123;

      if(provider == "tmd") {
        return items.filter(item => {
          const lat = parseFloat(item.lat);
          const long = parseFloat(item.long);
          return lat >= minLat && lat <= maxLat && long >= minLong && long <= maxLong;
        });
      } else if(provider == "usgs") {
        return items.filter(item => {
          const [long, lat] = item.geometry.coordinates
          const longitude = parseFloat(long);
          const latitude = parseFloat(lat);
          return latitude >= minLat && latitude <= maxLat && longitude >= minLong && longitude <= maxLong;
        });
      } else {
        return items.filter(item => {
          const d = item.description.split(/\s+/)
          const lat = parseFloat(d[2])
          const long = parseFloat(d[3])   
          return lat >= minLat && lat <= maxLat && long >= minLong && long <= maxLong;
        });
      }
    }

    function getTmd() {
      /**
       * @type HTMLElement
       */
      const selectEle = event.target.nextElementSibling
      /**
       * @type HTMLElement
       */
      const parentEle = selectEle.parentElement
      const url = "/library/feed.php?provider=tmd";
      parentEle.classList.add("fetching")
      parentEle.querySelector('.loading').style.display = "block";

      fetch(url)
        .then(resp => resp.json())
        .then(resp => {
          const items = resp.data.channel.item
          const filteredItems = filterLatLong(items, "tmd")
          window.tmdEvents = filteredItems;
          let options = `<option value="">Select (found ${filteredItems.length} events)</option>`

          filteredItems.forEach((item, id) => {
            options += `<option value="${id}">${item.title} ${item.lat} ${item.long} ${item.pubDate} depth(${item.depth} km.)</option>`
          })

          selectEle.innerHTML = options
          selectEle.removeAttribute('disabled')
          parentEle.classList.remove("fetching")
          parentEle.querySelector('.loading').style.display = "none";
        })
    }

    function getUsgs() {
      /**
       * @type HTMLElement
       */
      const selectEle = event.target.nextElementSibling
      const parentEle = selectEle.parentElement
      const url = "/library/feed.php?provider=usgs";
      parentEle.classList.add("fetching")
      parentEle.querySelector('.loading').style.display = "block";

      fetch(url)
        .then(resp => resp.json())
        .then(resp => {
          const items = resp.data?.features || []
          const filteredItems = filterLatLong(items, 'usgs')
          window.usgsEvents = filteredItems;
          let options = `<option value="">Select (found ${filteredItems.length} events)</option>`

          filteredItems.forEach((item, id) => {
            options += `<option value="${id}">${item.properties.title}</option>`
          })

          selectEle.innerHTML = options
          selectEle.removeAttribute('disabled')
          parentEle.classList.remove("fetching")
          parentEle.querySelector('.loading').style.display = "none";
        })
    }

    function getGeofon() {
      /**
       * @type HTMLElement
       */
      const selectEle = event.target.nextElementSibling
      const parentEle = selectEle.parentElement
      const url = "/library/feed.php?provider=gfz";
      parentEle.classList.add("fetching")
      parentEle.querySelector('.loading').style.display = "block";

      fetch(url)
        .then(resp => resp.json())
        .then(resp => {
          const items = resp.data?.channel?.item || []
          const filteredItems = filterLatLong(items, 'geofon')
          window.geofonEvents = filteredItems;
          let options = `<option>Select (found ${filteredItems.length} events)</option>`

          filteredItems.forEach((item, id) => {
            options += `<option value="${id}">${item.title}</option>`
          })

          selectEle.innerHTML = options
          selectEle.removeAttribute('disabled')
          parentEle.classList.remove("fetching")
          parentEle.querySelector('.loading').style.display = "none";
        })
    }
    /**
     * @param {"tmd" | "usgs" | "geofon"} provider
     */
    function handleImportClick(provider = "tmd") {
      const value = event.target.previousElementSibling.value
      const evnt = window[`${provider}Events`].find((_, i) => i == value)

      if (provider == "tmd") {
        const {
          long,
          lat,
          magnitude: mag,
          depth,
          time: date
        } = evnt

        setEventForm({
          long,
          lat,
          mag,
          depth,
          date: new Date(date)
        })
      } else if (provider == "usgs") {
        const {
          properties,
          geometry
        } = evnt
        const [long, lat, depth] = geometry.coordinates
        const {
          mag
        } = properties
        setEventForm({
          long,
          lat,
          mag,
          depth: Number.isInteger(depth) ? depth : depth.toFixed(1),
          date: new Date(properties.time)
        })
      } else {
        const {
          description
        } = evnt
        const d = description.split(/\s+/)
        const lat = d[2]
        const long = d[3]
        const depth = d[4]
        const date = new Date(`${d[0]}T${d[1]}Z`)
        const mag = parseFloat(evnt.title.split(" ")[1])
        setEventForm({
          lat,
          long,
          depth,
          date,
          mag
        })
      }
    }

    /**
     * @param {{
     *  long: number,
     *  lat: number,
     *  mag: number, 
     *  depth: number,
     *  date: Date
     * }} values
     */
    function setEventForm({
      long,
      lat,
      mag,
      depth,
      date
    }) {
      const dateArr = date.toLocaleDateString().split("/")
      const dateValue = `${dateArr[2]}-${dateArr[0].toString().padStart(2, 0)}-${dateArr[1].toString().padStart(2, 0)}`
      const timeValue = date.toTimeString().split(" ")[0]

      document.querySelector("[name='long']").value = long
      document.querySelector("[name='lat']").value = lat
      document.querySelector("[name='magnitude']").value = mag
      document.querySelector("[name='depth']").value = depth
      document.querySelector("[name='date']").value = dateValue
      document.querySelector("[name='time']").value = timeValue
    }
  </script>
  <!--<script src="../script/submenu.js" type="text/javascript"></script>-->
  <META content="MSHTML 6.00.2900.2769" name=GENERATOR>
  <style type="text/css">
    #Layer1 {
      position: absolute;
      left: 4px;
      top: 8px;
      width: 99%;
      z-index: 1;
      height: 60px;
    }

    .style1 {
      font-size: 22px;
      color: #FFFFFF;
    }

    .style2 {
      color: #FFFFFF
    }
  </style>
  <!-- InstanceBeginEditable name="head" -->
  <style type="text/css">
    .style37 {
      color: #990000;
      font-weight: bold;
    }

    DIV#adv_box {
      BORDER-RIGHT: #b6d6e1 1px solid;
      PADDING-RIGHT: 0px;
      BORDER-TOP: #b6d6e1 1px solid;
      PADDING-LEFT: 20px;
      PADDING-BOTTOM: 5px;
      padding-right: 20px;
      MARGIN: 7px 0px 10px;
      BORDER-LEFT: #b6d6e1 1px solid;
      PADDING-TOP: 12px;
      BORDER-BOTTOM: #b6d6e1 1px solid;
      BACKGROUND-COLOR: #eef6fb
    }

    .style47 {
      color: #003366
    }

    .black_overlay {
      display: none;
      position: fixed;
      top: 0%;
      left: 0%;
      width: 100%;
      height: 100%;
      background-color: black;
      z-index: 1001;
      -moz-opacity: 0.9;
      opacity: .80;
      filter: alpha(opacity=80);
    }

    .white_content {
      display: none;
      position: fixed;
      top: 5%;
      bottom: 5%;
      height: 90%;
      left: 5%;
      right: 5%;
      width: 90%;
      padding: 2px;
      border: 2px solid orange;
      background-color: white;
      z-index: 1002;
      overflow: hidden;
    }

    .dataScrapingWrapper {
      padding-left: 40px;
    }

    .dataScrapingWrapper>div {
      display: flex;
      align-items: center;
      position: relative;
    }

    .dataScrapingWrapper>div>p {
      width: 90px;
      color: #003366;
      font-weight: bold;
    }

    .dataScrapingWrapper>div>img {
      margin-right: 5px;
      cursor: pointer;
    }

    .dataScrapingWrapper>div>select {
      width: 200px;
      margin-right: 5px;
    }

    .dataScrapingWrapper>div>.loading {
      z-index: 1;
      position: absolute;
      width: 100%;
      height: 100%;
      background-color: #ffffff91;
      display: none;
    }

    .dataScrapingWrapper>div.fetching>img {
      animation-name: refresh;
      animation-duration: 2s;
      animation-iteration-count: infinite;
      animation-timing-function: linear;
    }

    /* The animation code */
    @keyframes refresh {
      to {
        transform: rotate(360deg);
      }
    }
  </style>
  <script language="javascript">
    function hide() {
      document.getElementById('search_tbl').style.display == 'none'
      document.getElementById('hide').style.display = 'none';
      document.getElementById('unhide').style.display = '';
    }

    function unhide() {
      document.getElementById('search_tbl').style.display == ''
      document.getElementById('hide').style.display = '';
      document.getElementById('unhide').style.display = 'none';
    }

    /*function select_sim_result(sim_rest_box, sel_id) {
      if(document.getElementById(sel_id).checked == true) {
        document.getElementById(sel_id).checked=false;
        document.getElementById(sim_rest_box).style.background='';
      }else {
        document.getElementById(sel_id).checked=true;
        document.getElementById(sim_rest_box).style.background='#D1DCE9';
      }
    }*/

    function select_sim_result(sim_rest_box) {
      if (document.getElementById(sim_rest_box).style.background == "#D1DCE9") {
        document.getElementById(sim_rest_box).style.background = '';
      } else {
        document.getElementById(sim_rest_box).style.background = '#D1DCE9';
      }
    }

    function clear_search_form() {
      document.getElementById('f_name').value = '';
    }

    function jump(v) { //v3.0
      document.location.href = '<?= $_SERVER['PHP_SELF'] ?>?section=<?= $_REQUEST['section'] ?>&grp_id=' + v;
      // if (restore) selObj.selectedIndex=0;
    }

    function smw_data() {
      document.getElementById('light').style.display = 'block';
      document.getElementById('fade').style.display = 'block'
      document.getElementById('res').src = 'seismic_watch_data.php';
    }

    function refreshPage(url) {
      if (url) {
        window.location.href = url;
        return true;
      }
    }
  </script>
  <!-- InstanceEndEditable -->
  <script type="text/javascript">
    // <!--
    function MM_jumpMenu(targ, selObj, restore) { //v3.0
      eval(targ + ".location='" + selObj.options[selObj.selectedIndex].value + "'");
      if (restore) selObj.selectedIndex = 0;
    }
    // -->
  </script>
</HEAD>

<BODY onLoad="refreshImages()">
  <DIV id=header>
    <div class="style1" id="Layer1">
      <table border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td valign="top"><img src="../../image/image001.png" alt="" width="50px" height="50px"></td>
          <td valign="top">&nbsp;</td>
          <td valign="">
            <table width="0" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td>Tsunami Decision Support System</td>
              </tr>
            </table>
          </td>
          <td>&nbsp;</td>
        </tr>
      </table>
    </div>
  </DIV>
  <DIV id=main>
    <!-- MENU STARTS -->
    <DIV id=left_column>
      <DIV id="navigation">
        <DIV class=menu_item id=c1><A id="cs_1">Simulation</A></DIV>
        <DIV class=submenu_item id=c5> <A <?= $section[3] ?> id=cs_5 href="result.php?section=3">Database</A> </DIV>
        <DIV class=submenu_item id=c5> <A <?= $section[4] ?> id=cs_5 href="search.php?section=4"
            title="See the visualizatoin result">Search </A> </DIV>
        <DIV class=submenu_item id=c5> <A <?= $section['4.1'] ?> id=cs_5 href="bulletin_release.php?section=4.1"
            title="See the visualizatoin result">Bulletin </A> </DIV>
        <!--<DIV class=menu_item id=c1><A id="cs_1">Data Source </A></DIV>
      <DIV class=submenu_item id=c14> <A <?= $section[6] ?> id=cs_14 href="../data-source/file-browser.php?section=6" title="Go to data source manage page">File Browser </A> </DIV>-->
        <DIV class=menu_item id=c1><A id="cs_1">User</A></DIV>
        <DIV class=submenu_item id=c14><A <?= $section[0] ?> id=cs_14 href="../../library/logout.php"
            title="Logout of <?= $_SESSION['username'] ?>">
            <font color="#CCFF00">Logout</font> <strong>[
              <?= substr($_SESSION['username'], 0, 6) . "..." ?>
              ]</strong>
          </A> </DIV>
      </DIV>
    </DIV>
    <DIV id=middle_column>
      <DIV class="section bordered">
        <H2 id=icon_pick><img src="../../image/color_theory_small_icon.jpg" width="14"
            height="14">&nbsp;<!-- InstanceBeginEditable name="title_workspace" -->Search simulation and visualization
          results<!-- InstanceEndEditable --> </H2>
        <DIV class=tutorials_list><!-- InstanceBeginEditable name="visualization_output" -->
          <?php
          require '../../library/connectdb.inc.php';

          if (isset($_REQUEST['grp_id'])) {
            $g_default_id = $_REQUEST['grp_id'];
          } else {
            $sql = "SELECT * FROM `observe_group` WHERE `default` LIKE 'yes';";
            $rg = mysql_query($sql, $connection) or die("! could not select the group of simulation results");
            $obj = mysql_fetch_object($rg);
            $g_default_name = $obj->g_name;
            $g_default_id = $obj->id;
            $_REQUEST['grp_id'] = $g_default_id;
          }
          $selected_group[$g_default_id] = " selected";

          if ($_GET['magnitude'] != '') {
            //print_r($_GET);
            //exit;
            /*}
if (isset($_GET['name']) && !isset($_SESSION['location'])) {*/
            $_SESSION['name'] = $_GET['name'];
            $_SESSION['lat'] = $_GET['lat'];
            $_SESSION['long'] = $_GET['long'];
            $_SESSION['radius'] = $_GET['radius'];
            $_SESSION['magnitude'] = $_GET['magnitude'];
            $_SESSION['depth'] = $_GET['depth'];
            $_SESSION['date'] = $_GET['date'];
            $_SESSION['time'] = $_GET['time'];
            if (strlen($_SESSION['name']) > 0) {
              $_part[] = " `name` LIKE '%" . $_SESSION['name'] . "%'";
            }
          } else {
            /*$sql = "SELECT MAX(`magnitude`) AS `max_m`, MIN(`magnitude`) AS `min_m` FROM `sim_result` WHERE `grp_id` = ".$_REQUEST['grp_id'];
        $res = mysql_query($sql, $connection) or die('! query failed.');
        if(mysql_num_rows($res) == 1) {
        $obj = mysql_fetch_object($res);
        $_SESSION['min_m'] = round($obj->min_m, 2);
        $_SESSION['max_m'] = round($obj->max_m, 2);
        }
         */
          }
          ?>
          <table width="10" height="2" border="0">
            <tr>
              <td></td>
            </tr>
          </table>
          <form action="<?= $_SERVER['PHP_SELF'] ?>?section=4&grp_id=<?= $_REQUEST['grp_id'] ?>" method="get" name="search">
            <input type="hidden" name="section" value="4">
            <input type="hidden" name="grp_id" value="<?= $_REQUEST['grp_id'] ?>">
            <fieldset id="def"
              style="background-image:url(../../image/gradient-inner.png); background-repeat:repeat-x; display:">
              <legend>
                <strong class="style37">Enter necessary information</strong>&nbsp;
                <a href="javascript: void(0);"
                  onClick="javascript: document.getElementById('searrh_tbl').style.display='none'; document.getElementById('unhide').style.display=''; this.style.display='none';"
                  id="hide">Hide</a>
                <a href="javascript: void(0);"
                  onClick="javascript: document.getElementById('search_tbl').style.display=''; document.getElementById('hide').style.display=''; document.getElementById('unhide').style.display='none';"
                  id="unhide" style="display:none">Unhide</a>
              </legend>

              <!-- Data from Seismic Networks -->
              <u style="font-weight:bold;display:block;margin-top:10px;">Data from Seismic Networks :</u>
              <div class="dataScrapingWrapper">
                <?php
                $seismicProviders = ["tmd", "usgs", "geofon"];
                foreach ($seismicProviders as $pro) {
                ?>
                  <div>
                    <div class="loading"></div>

                    <p><?= strtoupper($pro) ?></p>
                    <img src="https://png.pngtree.com/png-clipart/20230805/original/pngtree-refresh-flat-yellow-color-icon-isolated-flat-load-vector-picture-image_9756936.png" alt="0" width="15" height="15" onclick="get<?= ucfirst($pro) ?>()">
                    <select aria-label="<?= $pro ?>" name="<?= $pro ?>Selector" style="height:23px;font-weight:bold" disabled onchange="event.target.nextElementSibling.removeAttribute('disabled')">
                      <option>Select</option>
                    </select>
                    <button type="button" disabled onclick="handleImportClick('<?= $pro ?>')">import</button>
                  </div>
                <?php
                }
                ?>
              </div>
              <!-- ------------------------ -->

              <!-- Data Input -->
              <table border="0" cellpadding="4" cellspacing="0" id="search_tbl">
                <tr>
                  <th colspan="6" align="left" valign="middle" bgcolor="" scope="col"><u>Search by</u> :</th>
                </tr>
                <tr>
                  <th align="left" valign="middle" bgcolor="" scope="col">&nbsp;</th>
                  <th align="left" valign="middle" bgcolor="" scope="col">&nbsp;</th>
                  <th align="left" valign="middle" bgcolor="" scope="col"><span class="style47">Earthquake info.</span>
                  </th>
                  <th valign="middern" bgcolor="" scope="col">&nbsp;</th>
                  <th align="left" bgcolor="" scope="col">&nbsp;
                    <?php
                    $time_now = time();
                    $year = date("Y", $time_now);
                    $date = date('Y-m-d', $time_now);
                    $time = date('H:i:s', $time_now);
                    if (strlen($_GET['date']) == 0 && !isset($_REQUEST['from'])) {
                      $_SESSION['date'] = $date;
                    }

                    if (strlen($_GET['time']) == 0 && !isset($_REQUEST['from'])) {
                      $_SESSION['time'] = $time;
                    }
                    ?>
                  </th>
                  <th align="left" bgcolor="" scope="col">&nbsp; </th>
                </tr>
                <tr>
                  <th align="left" valign="middle" bgcolor="" scope="col">&nbsp;</th>
                  <th align="left" valign="middle" bgcolor="" scope="col">&nbsp;</th>
                  <th align="left" valign="middle" bgcolor="" scope="col"><span
                      class="style47">&nbsp;&nbsp;&nbsp;&nbsp;+Date</span></th>
                  <th scope="col" valign="middern"><img src="../../image/buttonorange.gif" alt="0" width="7"
                      height="10"></th>
                  <th align="left" scope="col"><input name="date" type="date"
                      style="width:200px; text-align:center; font-weight:bold" id="date"
                      value="<?= !isset($_SESSION['date']) ? $date : $_SESSION['date'] ?>"></th>
                  <th align="left" scope="col">&nbsp; </th>
                </tr>
                <tr>
                  <th align="left" valign="middle" bgcolor="" scope="col">&nbsp;</th>
                  <th align="left" valign="middle" bgcolor="" scope="col">&nbsp;</th>
                  <th align="left" valign="middle" bgcolor="" scope="col"><span
                      class="style47">&nbsp;&nbsp;&nbsp;&nbsp;+Time</span></th>
                  <th scope="col" valign="middern"><img src="../../image/buttonorange.gif" alt="0" width="7"
                      height="10"></th>
                  <th align="left" scope="col"><input name="time" type="text"
                      style="width:200px; text-align:center; font-weight:bold" id="time"
                      value="<?= !isset($_SESSION['time']) ? $time : $_SESSION['time'] ?>"></th>
                  <th align="left" scope="col">&nbsp;</th>
                </tr>
                <tr>
                  <th align="left" valign="middle" bgcolor="" scope="col">&nbsp;</th>
                  <th align="left" valign="middle" bgcolor="" scope="col">&nbsp;</th>
                  <th align="left" valign="middle" bgcolor="" scope="col"><span class="style47">Location :</span></th>
                  <th valign="middern" bgcolor="" scope="col"><input name="name" type="hidden"
                      style="width:350px; text-align:center; font-weight:bold" id="f_name"
                      value="<?= $_SESSION['name'] ?>"></th>
                  <th colspan="2" align="left" bgcolor="" scope="col">
                    <font color="#990000" style="font-weight:normal">
                      <?= isset($_REQUEST['from']) ? $_SESSION['location'] : "" ?>
                    </font>
                  </th>
                </tr>
                <tr>
                  <th align="left" valign="middle" bgcolor="" scope="col">&nbsp;</th>
                  <th align="left" valign="middle" bgcolor="" scope="col">&nbsp;</th>
                  <th align="left" valign="middle" bgcolor="" scope="col"><span
                      class="style47">&nbsp;&nbsp;&nbsp;&nbsp;+Latitude</span></th>
                  <th scope="col" valign="middern"><img src="../../image/buttonorange.gif" alt="0" width="7"
                      height="10"></th>
                  <th align="left" scope="col"><input name="lat" type="text"
                      style="width:200px; text-align:center; font-weight:bold" id="lat"
                      value="<?= (float) $_SESSION['lat'] ?>"></th>
                  <th align="left" scope="col">
                    <font color="#990000" style="font-weight:normal">
                      <!--* For  searching with latitude and longitude, please set M and Δ to zero.</font>-->
                  </th>
                </tr>
                <tr>
                  <th align="left" valign="middle" bgcolor="" scope="col">&nbsp;</th>
                  <th align="left" valign="middle" bgcolor="" scope="col">&nbsp;</th>
                  <th align="left" valign="middle" bgcolor="" scope="col"><span
                      class="style47">&nbsp;&nbsp;&nbsp;&nbsp;+Longitude</span></th>
                  <th scope="col" valign="middern"><img src="../../image/buttonorange.gif" alt="0" width="7"
                      height="10"></th>
                  <th align="left" scope="col"><input name="long" type="text"
                      style="width:200px; text-align:center; font-weight:bold" id="long"
                      value="<?= (float) $_SESSION['long'] ?>"></th>
                  <th align="left" scope="col" style="font-weight:normal">
                    <!--*&nbsp;<a href="javascript: void(0)" onClick="javascript: enable_map(document.getElementById('lat').value, document.getElementById('long').value);">See&nbsp;location</a>-->
                  </th>
                </tr>
                <!--<tr>
              <th align="left" valign="middle" bgcolor="" scope="col">&nbsp;</th>
              <th align="left" valign="middle" bgcolor="" scope="col">&nbsp;</th>
              <th align="left" valign="middle" bgcolor="" scope="col"><span class="style47">&nbsp;&nbsp;&nbsp;&nbsp;+Redius</span></th>
              <th scope="col" valign="middern"><img src="../../image/buttonorange.gif" alt="0" width="7" height="10"></th>
              <th align="left" scope="col"><input name="radius" type="text" id="radius" style="width:100px; text-align:center; font-weight:bold" value="<?= $_SESSION['radius'] ?>"></th>
            </tr>-->
                <tr>
                  <th align="left" valign="middle" bgcolor="" scope="col">&nbsp;</th>
                  <th align="left" valign="middle" bgcolor="" scope="col">&nbsp;</th>
                  <th align="left" valign="middle" bgcolor="" scope="col"><span class="style47">Magnitude</span></th>
                  <th scope="col" valign="middern"><img src="../../image/buttonorange.gif" alt="0" width="7"
                      height="10"></th>
                  <th align="left" scope="col"><input name="magnitude" type="text" id="magnitude"
                      style="width:200px; text-align:center; font-weight:bold"
                      value="<?= (float) $_SESSION['magnitude'] ?>"></th>
                  <th align="left" scope="col">&nbsp;</th>
                </tr>
                <tr>
                  <th align="left" valign="middle" bgcolor="" scope="col">&nbsp;</th>
                  <th align="left" valign="middle" bgcolor="" scope="col">&nbsp;</th>
                  <th align="left" valign="middle" bgcolor="" scope="col"><span class="style47">Depth (km)</span></th>
                  <th scope="col" valign="middern"><img src="../../image/buttonorange.gif" alt="0" width="7"
                      height="10"></th>
                  <th align="left" scope="col"><input name="depth" type="text" id="depth"
                      style="width:200px; text-align:center; font-weight:bold;" value="<?= (float) $_SESSION['depth'] ?>">
                  </th>
                  <th align="left" scope="col">&nbsp;</th>
                </tr>
                </tr>

              </table>
            </fieldset>
            <table width="10" height="2" border="0">
              <tr>
                <td></td>
              </tr>
            </table>
            <!--<input name="smw_data" type=button class=butenter id=smw_data style="PADDING-RIGHT: 3px; PADDING-LEFT: 3px; PADDING-BOTTOM: 3px; COLOR: #ffffff; PADDING-TOP: 3px;" onMouseOver="javascript:this.style.background='#ffffff'; this.style.color='#025778';" onMouseOut="javascript:this.style.background='#085D7E';this.style.color='white';  " value="Get data from Seismic Watch" onClick="javascript: location.href='read_smw_data.php';">-->
            <input name="search_btn" type=submit class=butenter id=search_btn
              style="PADDING-RIGHT: 3px; PADDING-LEFT: 3px; PADDING-BOTTOM: 3px; COLOR: #ffffff; PADDING-TOP: 3px;"
              onMouseOver="javascript:this.style.background='#ffffff'; this.style.color='#025778';"
              onMouseOut="javascript:this.style.background='#085D7E';this.style.color='white';  " value="Submit Query">
          </form>
          <table width="10" height="2" border="0">
            <tr>
              <td></td>
            </tr>
          </table>
          <div id="search_result_box"
            style="background-color:#FFFFCC; padding:4px 4px 4px 4px; border-top:#999999 1px solid"><strong>
              <?php
              require_once '../../library/connectdb.inc.php';

              foreach ($_GET as $varname => $value) {
                $_SESSION['search'][$varname] = $value;
              }

              $sq = "SELECT";
              $sq .= "	`id`, `job_profile_id`, `name`, `magnitude`, ";
              $sq .= "	`depth`, `decimal_lat`, `decimal_long`, ";
              $sq .= "	ROUND(SQRT(POW(`decimal_lat`-(" . floatval($_SESSION['lat']) . "), 2) + POW(`decimal_long`-(" . floatval($_SESSION['long']) . "), 2)), 3) AS `R` ";
              $sq .= "FROM `sim_result` WHERE `grp_id` = " . $_REQUEST['grp_id'];

              //print_r($_SESSION['magnitude']);

              if ($_SESSION['magnitude'] != 0) {
                if ($_SESSION['magnitude'] >= 0.1 && $_SESSION['magnitude'] <= 100) {
                  $m = $_SESSION['magnitude'];
                }
                $sq .= " AND `magnitude` >= " . (float) $m . " ";
              }
              if ($_SESSION['depth'] != 0) {
                if ($_SESSION['depth'] >= 0 && $_SESSION['depth'] <= 29.9) {
                  $d = 10;
                } else {
                  $d = 30;
                }
              }
              $sq .= " AND `depth` >= " . $d . " ";

              $sq .= " ORDER BY `depth` ASC , `magnitude` ASC  , `R` ASC";
              /*if ($_SESSION['magnitude'] != 0 || $_SESSION['lat'] != 0 || $_SESSION['long'] != 0  || $_SESSION['depth'] != 0){
                $sq .= " limit ";
              }*/

              /* pager*/
              $per_page = 20;

              if (!$_REQUEST['btn_r']) {
                $page = 1;
              } else {
                $page = $_REQUEST['curr_page_r'];
              }

              /**
               *
               *      SELECT 	`id`, `job_profile_id`, `name`, `magnitude`, 	`depth`, `decimal_lat`, `decimal_long`, 	ROUND(SQRT(POW(`decimal_lat`-(11.56), 2) + POW(`decimal_long`-(91.63), 2)), 3) AS `R` FROM `sim_result` WHERE `grp_id` = 1 AND `magnitude` = 8.5  ORDER BY `R` ASC
               *      echo "<pre>";
               *      echo $sq;
               *      echo "</pre>";
               */

              $res_count_page = mysql_query($sq, $connection);
              $page_start = ($per_page * $page) - $per_page;
              $num_rows = mysql_num_rows($res_count_page);

              if ($num_rows <= $per_page) {
                $num_page = 1;
              } elseif (($num_rows % $per_page) == 0) {
                $num_page = ($num_rows / $per_page);
              } else {
                $num_page = ($num_rows / $per_page) + 1;
                $num_page = (int) $num_page;
              }

              #if($_SESSION['magnitude'] <= 0 || $_SESSION['depth'] <= 0)
              $sq .= " LIMIT " . $page_start . ", " . $per_page;

              /* check Has `button` was clicked */
              if (!isset($_REQUEST['btn_r'])) {
                $curr_page_r = 1;
              } else {
                $curr_page_r = $_REQUEST['curr_page_r'];
              }
              if ($curr_page_r == $num_page) {
                $curr_page_r = $curr_page_r - 1;
              }

              $str_next_r = "document.location.href='" . $_SERVER['PHP_SELF'] . "?section=4&grp_id=" . $_REQUEST['grp_id'] . "&btn_r=next&curr_page_r=" . ($curr_page_r + 1) . "&name=" . $_SESSION['search']['name'] . "&desc=" . $_SESSION['search']['desc'] . "&lat=" . $_SESSION['search']['lat'] . "&long=" . $_SESSION['search']['long'] . "&radius=" . $_SESSION['search']['radius'] . "&mag_min=" . $_SESSION['search']['mag_min'] . "&mag_max=" . $_SESSION['search']['mag_max'] . "&depth=" . $_SESSION['search']['depth'] . "#search_result_box';";
              $selected_page_r[$_REQUEST['curr_page_r'] - 1] = " selected";

              for ($i = 0; $i < $num_rows; $i++) {
                $str_jump_page_r[($i + 1)] = $_SERVER['PHP_SELF'] . "?section=4&grp_id=" . $_REQUEST['grp_id'] . "&btn_r=next&curr_page_r=" . ($i + 1) . "&name=" . $_SESSION['search']['name'] . "&desc=" . $_SESSION['search']['desc'] . "&lat=" . $_SESSION['search']['lat'] . "&long=" . $_SESSION['search']['long'] . "&radius=" . $_SESSION['search']['radius'] . "&mag_min=" . $_SESSION['search']['mag_min'] . "&mag_max=" . $_SESSION['search']['mag_max'] . "&depth=" . $_SESSION['search']['depth'] . "&magnitude=" . $_REQUEST['magnitude'];
              }
              if ($page == 1) {
                //$start_r = 0;
                //$curr_page_r = 1;
                $str_back_r = "document.location.href='" . $_SERVER['PHP_SELF'] . "?section=4&grp_id=" . $_REQUEST['grp_id'] . "&btn_r=back&curr_page_r=" . $page . "&name=" . $_SESSION['search']['name'] . "&desc=" . $_SESSION['search']['desc'] . "&lat=" . $_SESSION['search']['lat'] . "&long=" . $_SESSION['search']['long'] . "&radius=" . $_SESSION['search']['radius'] . "&mag_min=" . $_SESSION['search']['mag_min'] . "&mag_max=" . $_SESSION['search']['mag_max'] . "&depth=" . $_SESSION['search']['depth'] . "#search_result_box';";
              } else {
                $str_back_r = "document.location.href='" . $_SERVER['PHP_SELF'] . "?section=4&grp_id=" . $_REQUEST['grp_id'] . "&btn_r=back&curr_page_r=" . ($page - 1) . "&name=" . $_SESSION['search']['name'] . "&desc=" . $_SESSION['search']['desc'] . "&lat=" . $_SESSION['search']['lat'] . "&long=" . $_SESSION['search']['long'] . "&radius=" . $_SESSION['search']['radius'] . "&mag_min=" . $_SESSION['search']['mag_min'] . "&mag_max=" . $_SESSION['search']['mag_max'] . "&depth=" . $_SESSION['search']['depth'] . "#search_result_box';";
              }

              $str_back_end_r = "document.location.href='" . $_SERVER['PHP_SELF'] . "?section=4&grp_id=" . $_REQUEST['grp_id'] . "&btn_r=back_end&curr_page_r=1&name=" . $_SESSION['search']['name'] . "&desc=" . $_SESSION['search']['desc'] . "&lat=" . $_SESSION['search']['lat'] . "&long=" . $_SESSION['search']['long'] . "&radius=" . $_SESSION['search']['radius'] . "&mag_min=" . $_SESSION['search']['mag_min'] . "&mag_max=" . $_SESSION['search']['mag_max'] . "&depth=" . $_SESSION['search']['depth'] . "#search_result_box'";

              $str_next_end_r = "document.location.href='" . $_SERVER['PHP_SELF'] . "?section=4&grp_id=" . $_REQUEST['grp_id'] . "&btn_r=next_end&curr_page_r=" . $num_page . "&name=" . $_SESSION['search']['name'] . "&desc=" . $_SESSION['search']['desc'] . "&lat=" . $_SESSION['search']['lat'] . "&long=" . $_SESSION['search']['long'] . "&radius=" . $_SESSION['search']['radius'] . "&mag_min=" . $_SESSION['search']['mag_min'] . "&mag_max=" . $_SESSION['search']['mag_max'] . "&depth=" . $_SESSION['search']['depth'] . "#search_result_box'";

              //echo $sq;

              $res = mysql_query($sq, $connection);
              if ($res) {
                if (mysql_num_rows($res) != null) {
                  $no = mysql_num_rows($res);
                  #$no = 1;
                  for ($a = 0; $a <= $no; $a++) {
                    #$a = 0;
                    $obj = mysql_fetch_object($res);
                    $sim_result[$a]['id'] = $obj->id;
                    $sim_result[$a]['job_profile_id'] = $obj->job_profile_id;
                    $sim_result[$a]['name'] = $obj->name;
                    #$sim_result[$a]['description'] = strlen($obj->desc) < 10 ? "(no specified description)" : $obj->desc;
                    #$sim_result[$a]['submit_date'] = $obj->datetime;
                    #$sim_result[$a]['domain'] = strlen($obj->domain) < 1 ? "(no specified Tsunami's domain)" : $obj->domain;
                    #$sim_result[$a]['source'] = strlen($obj->source) < 1 ? "(no specified Tsunami's source)" : $obj->source;
                    #$sim_result[$a]['observ_area'] = strlen($obj->observ_area) < 1 ? "(no specified Tsunami's observation area)" : $obj->observ_area;
                    $sim_result[$a]['magnitude'] = $obj->magnitude;
                    $sim_result[$a]['depth'] = $obj->depth;
                    #$sim_result[$a]['lat_degree'] = $obj->lat_degree;
                    #$sim_result[$a]['lat_lipda'] = $obj->lat_lipda;
                    #$sim_result[$a]['lat_Philipda'] = $obj->lat_Philipda;
                    #$sim_result[$a]['long_degree'] = $obj->long_degree;
                    #$sim_result[$a]['long_lipda'] = $obj->long_lipda;
                    #$sim_result[$a]['long_Philipda'] = $obj->long_Philipda;
                    $sim_result[$a]['decimal_lat'] = $obj->decimal_lat;
                    $sim_result[$a]['decimal_long'] = $obj->decimal_long;
                    $sim_result[$a]['r'] = $obj->R;
                  }
                } else {
                  $no = 0;
                }
              }
              ?>
            </strong>
            <table width="10" height="1" border="0">
              <tr>
                <td><?php //echo "<pre>"; print_r($_GET); print_r($_SESSION); echo "</pre>"; 
                    ?></td>
              </tr>
            </table>
            <?php if ($num_rows != 0) { ?>
              <div align="left">
                Page number :
                <select name="select" id="select-case">
                  <?php
                  for ($p = 1; $p <= $num_page; $p++) {
                  ?>
                    <option value="<?= $p ?>" data-url="<?= $str_jump_page_r[$p] ?>" <?= $selected_page_r[$p - 1] ?>>
                      <?= $p ?>
                    </option>
                  <?php
                  }
                  ?>
                </select>

                Total<font color="#990000">&nbsp;<b>
                    <?= $num_rows ?>
                  </b></font>&nbsp;record(s).
              </div>
            <?php } ?>
            <table width="10" height="1" border="0">
              <tr>
                <td></td>
              </tr>
            </table>
            <strong>Results&nbsp;:&nbsp;</strong>found <font color="#FF0000">
              <?= $num_rows ?>
            </font> record(s) <font color="#FF0000">
              <?= $num_page ?>
            </font> Pages, display <font color="#FF0000">
              <?= $per_page ?>
            </font> records per page.<br>
            <table width="10" height="2" border="0">
              <tr>
                <td></td>
              </tr>
            </table>
            <div id="adv_box" style="">
              <?php
              for ($g = 0; $g < $no; $g++) {
              ?>
                <table width="100%" border="0" cellpadding="0" cellspacing="0" id="sim_rest_<?= $g ?>">
                  <tr <?php if ($g != 0 || $page_start != 0) { ?>
                    onMouseOver="javascript: this.style.background='#D0EFFB'; this.style.borderBottom='#A4ED8B 1px solid'; this.style.borderTop='#A4ED8B 1px solid';  document.getElementById('s<?= $sim_result[$g]['id'] ?>').style.display='';"
                    onMouseOut="javascript: this.style.background=''; this.style.borderBottom=''; this.style.borderTop=''; document.getElementById('s<?= $sim_result[$g]['id'] ?>').style.display='none';"
                    <?php } ?>>
                    <td>
                      <table border="0" cellpadding="0" cellspacing="1">
                        <tr>
                          <!--<td rowspan="5" valign="top"><input type="checkbox" name="sel[<?= $g ?>]" id="sel_[<?= $g ?>]" onClick="javascript: document.getElementById('sim_rest_<?= $g ?>').style.background='#D1DCE9';"></td>-->
                          <td rowspan="5" valign="top">&nbsp;</td>
                          <td rowspan="5" valign="top"><?php
                                                        $today = date('d', time());
                                                        $cd = date('d', $sim_result[$g]['submit_date']);
                                                        ?>
                            <a
                              href="../bulletin/general.php?id=<?= $sim_result[$g]['id'] ?>&job_profile_id=<?= $sim_result[$g]['job_profile_id'] ?>">
                              <?php
                              if ($g == 0 && $page_start == 0) {
                              ?>
                                <table width="85" height="80" border="0" cellpadding="0" cellspacing="0"
                                  background="../../image/image001.png">
                                  <tr>
                                    <td height="18">&nbsp;</td>
                                  </tr>
                                  <tr>
                                    <td height="33">&nbsp;</td>
                                  </tr>
                                </table>
                              <?php
                              } else {
                              ?>
                                <table width="49" height="51" border="0" cellpadding="0" cellspacing="0"
                                  background="../../image/blog-calendar.png">
                                  <tr>
                                    <td height="18">
                                      <div align="center">
                                        <font color="white"> M
                                          <?= $sim_result[$g]['magnitude'] ?>
                                        </font>
                                      </div>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td height="33">
                                      <div align="center"> Δ
                                        <?= $sim_result[$g]['depth'] ?>
                                      </div>
                                    </td>
                                  </tr>
                                </table>
                              <?php
                              }
                              ?>
                            </a>
                          </td>
                          <td rowspan="5" valign="top">&nbsp;</td>
                          <td align="left" valign="top"></td>
                        </tr>
                        <tr>
                          <td align="left" valign="top"><?php
                                                        if ($g == 0 && $page_start == 0) {
                                                        ?>
                              <table width="0" border="0" cellspacing="1" cellpadding="0">

                                <tr>
                                  <td>Magnitude: <font color="#0000CC"><?= number_format($sim_result[$g]['magnitude'], 1) ?>
                                    </font>
                                  </td>
                                </tr>
                                <tr>
                                  <td>Depth: <font color="#0000CC"><?= $sim_result[$g]['depth'] ?></font> km.</td>
                                </tr>
                                <tr>
                                  <td>Latitude:<font color="#0000CC">
                                      <?= $sim_result[$g]['decimal_lat'] ?>
                                    </font>
                                  </td>
                                </tr>
                                <tr>
                                  <td>Longitude: <font color="#0000CC">
                                      <?= $sim_result[$g]['decimal_long'] ?>
                                    </font>
                                  </td>
                                </tr>
                              </table>
                            <?php
                                                        } else {
                            ?>
                              <table width="0" border="0" cellspacing="1" cellpadding="0">
                                <tr>
                                  <td>Magnitude: <font color="#0000CC">
                                      <?= number_format($sim_result[$g]['magnitude'], 1) ?>
                                    </font> , Depth: <font color="#0000CC">
                                      <?= $sim_result[$g]['depth'] ?>
                                    </font> km.</td>
                                </tr>
                                <tr>
                                  <td>Latitude:<font color="#0000CC">
                                      <?= $sim_result[$g]['decimal_lat'] ?>
                                    </font>, Longitude: <font color="#0000CC">
                                      <?= $sim_result[$g]['decimal_long'] ?>
                                    </font>
                                  </td>
                                </tr>
                                <tr>
                                  <td></td>
                                </tr>
                              </table>
                            <?php
                                                        }
                            ?>
                          </td>
                        </tr>
                      </table>
                    </td>
                    <td><?php
                        if ($g == 0 && $page_start == 0) {
                          $display = "";
                        } else {
                          $display = "none";
                        }

                        ?>
                      <div id="s<?= $sim_result[$g]['id'] ?>" style="display:<?= $display ?>">
                        <script language="javascript">
                          var d = document.getElementById('date').value;
                          var t = document.getElementById('time').value;
                          var lat = document.getElementById('lat').value;
                          var long = document.getElementById('long').value;
                          var magnitude = document.getElementById('magnitude').value;
                          var depth = document.getElementById('depth').value;

                          function create_bulletin(id, name) {
                            window.location.href = 'bulletin.php?section=4.1&id=' + id + '&name=' + name + '&grp_id=<?= $_REQUEST['grp_id'] ?>&date=' + d + '&time=' + t + '&lat=' + lat + '&long=' + long + '&magnitude=' + magnitude + '&depth=' + depth;
                          }
                        </script>
                        <div align="right"><a
                            onClick="javascript: create_bulletin(<?= $sim_result[$g]['id'] ?>, '<?= $sim_result[$g]['name'] ?>');"
                            href="javascript: void(0);">Create&nbsp;Bulletin</a> Reference ID =
                          <?= $sim_result[$g]['name'] ?> / <?php echo $sim_result[$g]['id']; ?>
                          , Distance from epicenter =
                          <?= $sim_result[$g]['r'] ?>
                          &nbsp;deg.
                        </div>
                      </div>
                    </td>
                  </tr>
                </table>
                <table width="10" height="2" border="0">
                  <tr>
                    <td></td>
                  </tr>
                </table>
              <?php
              }
              ?>
            </div>

            <div id="light" class="white_content">
              <iframe src="" style="border-width:0px;" width="100%" height="100%" id="res">Something wrong !</iframe>
              <!-- end -->
            </div>
            <div id="fade" class="black_overlay"
              onClick="javascript: document.getElementById('light').style.display='none'; document.getElementById('fade').style.display='none';">
            </div>
            <!-- InstanceEndEditable -->
          </DIV>
          <DIV class="clear asd"></DIV>
        </DIV>
        <!-- FEATURED RESOURCES START -->
        <DIV id=margin_footer></DIV>
        <!-- FEATURED RESOURCES STOP -->
      </DIV>
    </DIV>
    <!--<DIV id=footer><a href="../../team.html" target="_blank" style="color:white">Developer Team</a></DIV>-->
</BODY>
<!-- InstanceEnd -->

</HTML>