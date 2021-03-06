<?php
// include("Controller/Theloai.class.php");
// include("Controller/Manga.class.php");
include("Controller/Theloaitruyen.class.php");
?>
<?php
include_once("header.php");
$danhsachtheloai = Theloai::Theloaitruyen();
?>
<?php
if (isset($_POST["btnsubmit"])) {
  $TenManga = $_POST["TenManga"];
  $TenKhac = $_POST["TenKhac"];
  $Tacgia = $_POST["Tacgia"];
  $NguoiDich = $_POST["NguoiDich"];
  $GioiThieu = $_POST["GioiThieu"];
  $Anh = $_FILES["Images"];
  $Slug = $_POST["Slug"];
  $KieuTruyen = $_POST["KieuTruyen"];
  if(!empty($_POST["Theloai"]))
  {
    $themManga = new Manga($TenManga, $Slug, $TenKhac, $Tacgia, $NguoiDich, '0', $GioiThieu, '0', $_SESSION["user"], $Anh, $KieuTruyen);
    $result = $themManga->save();
    foreach ($_POST["Theloai"] as  $itemId) {
      $themtheloaitruyen = new Theloaitruyen($result, $itemId);
      $themtheloaitruyen->savetheloaitruyen();
    }
    if (!$themtheloaitruyen) {
      header("Location: /websitetruyen/dangtruyen.php?failure");
    } else {
      $truluot = User::TruSoLuotTaoTruyen($_SESSION["user"],'1');
      if($truluot)
      {
        header("Location: tutruyen.php?matk=".$_SESSION["user"]);
      }
      else
      {
         header("Location: /websitetruyen/dangtruyen.php?failure");
      }
      
    }
  }
  else
  {
     header("Location: /websitetruyen/dangtruyen.php?error");
  } 
}
?>
<section class="main-content">
  <div class="container" id="pageregman">
    <?php
    if (isset($_GET["failure"])) {
      echo '<div class="alert alert-warning">Fuck</div>';
    }
    if (isset($_GET["error"])) {
      echo '<div class="alert alert-danger">Bạn phải chọn thể loại truyện ít nhất 1 thể loại</div>';
    }
    if (isset($_GET["inserted"])) {

      echo '<div class="alert alert-success">OKE</div>';
    }

    ?>
    <div class="messages">
      <form method="post" enctype="multipart/form-data" id="Dangkytruyen">
        <div class="col-lg-2">
          <img id="ImageManga" class="image-avatar" src="<?php echo "/websitetruyen/FileCSSJS/assets/images/0.jpg"; ?>" width="150px" height="150px" />
          <input type="file" multiple="false" name="Images" id="Images" style="display: none;" onchange="img_pathUrl(this)" />
          <button class="button is-danger btn-avatar" type="button" style="margin-left: 25px;" id="clickFile">
            Chọn Hình
          </button>
        </div>
        <div class="col-lg-10">
          <div class="field">
            <p class="txt">Tên Truyện :</p>
            <p class="control">
              <input class="input" name="TenManga" id="MangaName" type="text" value="<?php echo isset($_POST["TenManga"]) ? $_POST["TenManga"] : ""; ?>" placeholder="Đảo Hải Tặc" />
            </p>
          </div>
          <div class="field">
            <p class="txt">Đường dẫn</p>
            <p class="control">
              <input class="input" type="text" id="Slug" name="Slug" value="<?php echo isset($_POST["Slug"]) ? $_POST["Slug"] : ""; ?>" placeholder="dao-hai-tac" />
            </p>
          </div>
          <div class="field">
            <p class="txt">Tên Khác:</p>
            <p class="control">
              <input class="input" id="OrtherName" name="TenKhac" type="text" value="<?php echo isset($_POST["TenKhac"]) ? $_POST["TenKhac"] : ""; ?>" placeholder="Onepice, Đảo Kho Báu, Vua Cướp Biển" />
            </p>
          </div>
          <div class="field">
            <p class="txt">Tác Giả :</p>
            <p class="control">
              <input class="input" type="text" id="Tacgia" name="Tacgia" value="<?php echo isset($_POST["Tacgia"]) ? $_POST["Tacgia"] : ""; ?>" placeholder="Oda " />
            </p>
          </div>
          <div class="field">
            <p class="txt">Người Dịch :</p>
            <p class="control">
              <input class="input" type="text" id="Editor" name="NguoiDich" value="<?php echo isset($_POST["NguoiDich"]) ? $_POST["NguoiDich"] : ""; ?>" placeholder="49" />
            </p>
          </div>
          <div class="field user-field">
            <p class="txt">Kiểu Truyện :</p>
            <p class="control" style="margin-left: 10%;">
              <input type="radio" id="KieuTruyen" name="KieuTruyen" value="1" checked>
              <label for="KieuTruyen" class="col-sm-5">Truyện Tranh</label>
              <input type="radio" id="KieuTruyen1" name="KieuTruyen" value="2">
              <label for="KieuTruyen1" class="col-sm-5">Truyện Chữ</label>
            </p>

          </div>
          <br />
          <div class="field">
            <p class="txt">Thể loại :</p>
            <p class="control" style="margin-left: 10%;">
              <?php
              foreach ($danhsachtheloai as $item) {
              ?>
                <input type="checkbox" id="Theloai[<?php echo $item["IdTheloai"]; ?>]" name="Theloai[]" value="<?php echo $item["IdTheloai"]; ?>" style="margin: 5px 5px 5px 5px;">
                <label for="Theloai[<?php echo $item["IdTheloai"]; ?>]" class="col-sm-3" style="margin: 5px 5px 5px 5px;"><?php echo $item["TenTheloai"]; ?></label>
              <?php } ?>
            </p>
          </div>
        </div>
        <div class="row" style="margin: 30px 30px 30px 30px;">
          <div class="field">
            <p class="txt">Nội dung:</p>
            <p class="control">
              <textarea name="GioiThieu" id="GioiThieu" value="<?php echo isset($_POST["GioiThieu"]) ? $_POST["GioiThieu"] : ""; ?>"></textarea>
            </p>
          </div>
        </div>
        <div style="text-align: center;">
          <button class="button is-danger" type="submit" name="btnsubmit">Đăng Ký</button>
        </div>
      </form>
    </div>

  </div>
</section>


<script type="text/javascript">
  $("#clickFile").click(function() {
    $("#Images").click();
  });
  $("#MangaName").keyup(function() {
    var str = $(this).val();
    var trims = $.trim(str);
    // trims.replace(/[^a-z0-9]/gi, '-').replace(/-+/g, '-').replace(/^-|-$/g, '-');
    var slug = trims
      .replace(/á|à|ả|ạ|ã|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ/gi, "a")
      .replace(/é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ/gi, "e")
      .replace(/i|í|ì|ỉ|ĩ|ị/gi, "i")
      .replace(/ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ/gi, "o")
      .replace(/ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự/gi, "u")
      .replace(/ý|ỳ|ỷ|ỹ|ỵ/gi, "y")
      .replace(/đ/gi, "d")
      .replace(
        /\`|\~|\!|\@|\#|\||\$|\%|\^|\&|\*|\(|\)|\+|\=|\,|\.|\/|\?|\>|\<|\'|\"|\:|\;|_/gi,
        ""
      )
      .replace(/ /gi, "-")
      .replace(/\-\-\-\-\-/gi, "")
      .replace(/\-\-\-\-/gi, "-")
      .replace(/\-\-\-/gi, "-")
      .replace(/\-\-/gi, "-")
      .replace(/\@\-|\-\@|\@/gi, "");
    // $('#slug').val(slug.toLowerCase()+".html")
    $("#Slug").val(slug.toLowerCase());
  });
</script>
<script>
  function img_pathUrl(input) {
    // $('#ImageManga')[0].src = (window.URL ? URL : webkitURL).createObjectURL(input.files[0]);
    $("#ImageManga")[0].src = URL.createObjectURL(event.target.files[0]);
  }
  $("#MangaType").click(function() {
    if ($("#MangaType1").attr('checked', true)) {
      $("#MangaType1").removeAttr('checked');
    }
  });
  $("#MangaType1").click(function() {
    if ($("#MangaType").attr('checked', true)) {
      $("#MangaType").removeAttr('checked');
    }
  });
</script>
<script type="text/javascript">
  tinymce.init({
    selector: "textarea",
    plugins: [
      'advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker',
      'searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking',
      'table emoticons template paste help'
    ],
    toolbar: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | ' +
      'bullist numlist outdent indent | link image | print preview media fullpage | ' +
      'forecolor backcolor emoticons | help',
    menu: {
      favs: {
        title: 'My Favorites',
        items: 'code visualaid | searchreplace | spellchecker | emoticons'
      }
    },
    toolbar_groups: {
      formatgroup: {
        icon: "format",
        tooltip: "Formatting",
        items: "bold italic underline strikethrough | forecolor backcolor | superscript subscript | removeformat",
      },
      paragraphgroup: {
        icon: "paragraph",
        tooltip: "Paragraph format",
        items: "h1 h2 h3 | bullist numlist | alignleft aligncenter alignright | indent outdent",
      },
      insertgroup: {
        icon: "plus",
        tooltip: "Insert",
        items: "link image emoticons charmap hr",
      },
    },
    skin: "outside",
    toolbar_location: "bottom",
    menubar: false,
    height: 700,
    with: 500,
    file_picker_types: "image",
    file_picker_callback: function(cb, value, meta) {
      var input = document.createElement("input");
      input.setAttribute("type", "file");
      input.setAttribute("accept", "image/*");
      // input.setAttribute("multiple","true");

      input.onchange = function() {
        var file = this.files[0];
        var reader = new FileReader();

        reader.onload = function() {
          var id = "blobid" + new Date().getTime();
          var blobCache = tinymce.activeEditor.editorUpload.blobCache;
          var base64 = reader.result.split(",")[1];
          var blobInfo = blobCache.create(id, file, base64);
          blobCache.add(blobInfo);

          // call the callback and populate the Title field with the file name
          cb(blobInfo.blobUri(), {
            title: file.name
          });
        };
        reader.readAsDataURL(file);
      };
      input.click();
    },
  });
</script>


<?php include_once("footer.php"); ?>