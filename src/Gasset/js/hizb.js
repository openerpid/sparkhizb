var $referensi = localStorage.getItem("referensi");
var $ref = JSON.parse($referensi);

var $hizb = {
  register: function () {
    $hizb.config.autoload();
  },

  routes: {
    mechanic_activity: {
      edit: function (row, index) {
        app.Controllers.edit(row, index);
      },
    },

    auth: {
      username: function () {
        app.Controllers.username();
      },
    },
  },

  vars: {
    id: null,
    ids: null,
    base_url: null,
    page_url: null,
    page: null,
    action: null,
    class: null,
    location_hash: null,
    error_ids: [],
    page_previous: null,
    errors: [],
    row: null,
    rows: null,
    is_row: null,
    rad_external: 0,
    nav_tab: null,
    nav_tab_id: null,
    crud: null,
    module_kode: null,
    site_project_kode: null,
    required_field: [],
    index: null,
    element_id: null,
    arrayqu: [],
    kode: null,
    status_id: null,

    msdbToken: localStorage.getItem("msdbToken"),
    urlpath: window.location.href,
    urlParams: new URLSearchParams(window.location.search),
    show_col_images: localStorage.getItem("show_col_images"),
    show_col_id: localStorage.getItem("show_col_id"),
    toggle_sidebar: localStorage.getItem("toggle_sidebar"),
    no_image_path: "uploads/no_image.jpg",

    mode_form: null,
    dataIndex: null,
    woID: null,

    date_start: null,
    date_end: null,

    time_start: null,
    time_end: null,

    min_time: null,
    max_time: null,

    dNow: new Date().toISOString().slice(0, 10),
    tNow: new Date().toTimeString().slice(0, 8),

    select2: {
      id: null,
      text: null,
      name: null,
    },

    identity: {
      account_id: null,
      nikaryawan: null,
      name: null,

      plant_id: null,
      plant_kode: null,
      plant_name: null,
      plant: null,

      lokasi_temuan_id: null,
      site_project_kode: null,
      site_project_kode2: null,
      site_project_name: null,
      site_project: null,
    },

    account: {
      id: null,
      role: null,
      level_id: null,
    },

    dt: {
      nth_child_onclick: null,
    },

    hcm: {
      payroll: {
        gapok: null,
        rapel_gaji: null,
        lain_lain: null,
        insentif_produksi: null,
        insentif_kehadiran: null,
        tj_kesetaraan: null,
        tj_acting: null,
        potongan_jamsostek_jht: null,
        potongan_jamsostek_jp: null,
        potongan_kasbon: null,
        potongan_tiket: null,
        total_tunjangan: null,
        total_potongan: null,
        gaji_bruto: null,
        gaji_netto: null,
        saldo_kasbon: null,
        qrcode: null,
      },
    },

    safety: {
      hazard_report: {
        data: null,
        document_number: null,
      },
    },

    file: {
      // formData: new FormData().append("file_upload",$("#file_upload")[0].files[0]),
      // $hizb.vars.file.formData.append("file_description", $("#file_description").val()),
    },
  },

  config: {
    autoload: function () {
      // app.Events.initTable()
      $hizb.events.onClick.dorbittButton();
      $hizb.events.onChange.dorbittCheckBox();
      $hizb.events.onChange.dorbittRadio();
      $hizb.events.onChange.selectOption();
      $hizb.gallery.button();
      $hizb.events.onChangeFileGalleryUpload();
      $hizb.events.gallery.btn_show_gallery();
      $hizb.mygallery.autoload();
      // $hizb.events.gallery.btn_submit_file_upload();
      // $('#btn_login').on('click', function(){

      // })
      if ( typeof bsCustomFileInput !== 'undefined' && bsCustomFileInput == 'textpage' ) {
        bsCustomFileInput.init();
      }
      
      $(".btn-max").on("click", function () {
        var modalid = $(this).data("modalid");
        console.log(modalid);
        if (modalid == undefined) {
          $hizb.views.modal.fullscreen("#modal_form #modal_dialog");
        } else {
          $hizb.views.modal.fullscreen("#" + modalid + " #modal_dialog");
        }
      });

      $("nav .nav-tabs .nav-link").on("click", function () {
        var nav_tab_id = $(this).attr("id");
        localStorage.setItem("nav_tab_id", nav_tab_id);
        $hizb.vars.nav_tab_id = nav_tab_id;
      });

      // if ( $.isFunction($.fn.lettering) ) {
      //     $(".cs-text-cut").lettering('words');
      // }

      if(typeof jQuery.fn.datepicker !== "undefined") {
        $(".datepicker000").datepicker({
          dateFormat: "yy-mm-dd",
          uiLibrary: "bootstrap4",
          modal: true,
          header: true,
          footer: true,
        });

        $(".ummu-datepicker").datepicker({
          dateFormat: "yy-mm-dd",
          uiLibrary: "bootstrap4",
          modal: true,
          header: true,
          footer: true,
        });
      };

      if(typeof jQuery.fn.clockpicker !== "undefined") {
        $(".clockpicker").clockpicker({
          // placement: 'top',
          autoclose: true,
          align: "left",
          donetext: "Done",
          default: "now",
        });

        $(".ummu-clockpicker").clockpicker({
        // placement: 'top',
          autoclose: true,
          align: "left",
          donetext: "Done",
          default: "now",
        });
      };

      $("#modal_filter").on("shown.bs.modal", function () {
        let date_from = localStorage.getItem("date_from");
        let time_from = localStorage.getItem("time_from");

        let date_to = localStorage.getItem("date_to");
        let time_to = localStorage.getItem("time_to");

        $("#date_from").val(date_from);
        $("#time_from").val(time_from);

        $("#date_to").val(date_to);
        $("#time_to").val(time_to);
      });

      $("#modal_filter #btn_save_filter").on("click", function () {
        var date_from = $("#date_from").val();
        var time_from = $("#time_from").val();
        var date_to = $("#date_to").val();
        var time_to = $("#time_to").val();
        var site_project_kode = $("#site_project_kode").val();

        localStorage.setItem("date_from", date_from);
        localStorage.setItem("time_from", time_from);
        localStorage.setItem("date_to", date_to);
        localStorage.setItem("time_to", time_to);
        localStorage.setItem("site_project_kode", site_project_kode);

        $("#modal_filter").modal("hide");

        table.ajax.reload();
      });

      $(".btn-add-to-list").on("click", function () {
        if ($hizb.vars.index == null) {
          $hizb.vars.index = 0;
        } else {
          $hizb.vars.index = $hizb.vars.index + 1;
        }

        var dataInputID = $(this).attr("data-inputid");
        $hizb.vars.element_id = dataInputID + "_list";
        var tVal = $("#" + dataInputID).val();
        var text =
        '<li class="list-group-item d-flex justify-content-between align-items-center" style="padding:0px 0px 0px 10px;" id="index' +
        $hizb.vars.index +
        '">' +
        '<span class="list-group-item-text">' +
        tVal +
        "</span>" +
        '<button type="button" class="btn btn-sm btn-outline-danger" onclick="$hizb.func.remove_element_by_index(' +
        $hizb.vars.index +
        ');"><i class="fas fa-trash-alt"></i></button>' +
        "</li>";
        if (tVal) {
          $("#" + dataInputID + "_list").append(text);
        }
        $("#" + dataInputID).val("");

        // console.log(text)
      });

      // $('#txtSearchProdAssign').keypress(function (e) {
      //     var key = e.which;
      //     if(key == 13)  // the enter key code
      //     {
      //         $('input[name = butAssignProd]').click();
      //         return false;
      //     }
      // });

      $(".btn-show-date").on("click", function () {
        var id = $(this).data("inputid");

        $("#" + id).datepicker("show");
      });

      $(".btn-show-time").on("click", function (e) {
        var id = $(this).data("inputid");

        e.stopPropagation();
        $("#" + id).clockpicker("show");
      });
    },
  },

  events: {
    initTable: function () {
      // $table.bootstrapTable({
      //     locale: 'en-US',
      // })
      // $table.on('check.bs.table uncheck.bs.table check-all.bs.table uncheck-all.bs.table', function () {
      //     $remove.prop('disabled', !$table.bootstrapTable('getSelections').length);
      //     // save your data, here just save the current page
      //     seldata: dataections = $globFunc.getIdSelections();
      // })
      // $table.on('all.bs.table', function (e, name, args) {
      //     console.log(name, args)
      // })
      // $remove.click(function () {
      //     $('#btn_multiple_delete').attr('onclick','Routes.multiple_delete();')
      //     $('#modal_confirmation_multiple_delete').modal('show')
      // })
    },

    onChangeFileGalleryUpload: function () {
      $("#file_upload").change(function () {
        var $id = $("#upload_img_thumbnail");
        var $filename = $(this)[0].files[0].name;
        var reader = new FileReader();
        reader.onload = function (e) {
          $($id).attr("src", e.target.result);
          // alert(e.target.result)
          $hizb.upload.filename = $filename;
        };
        reader.readAsDataURL($(this)[0].files[0]);
      });
    },

    /*onChange: {
            checkBox: function() {
                // $("#proyektor").change(function() {
                //     if(this.checked) {
                //         globalVars.proyektor = 1
                //     }else{
                //         globalVars.proyektor = 0
                //     }
                // });
            },

            selectOption: function() {
                $('#gedung').change(function() {
                    var maxNum = $(this).find(':selected').attr('data-lantai');
                    $('#lantai').val("");
                    $('#lantai').attr('max',maxNum);
                });
            }
        },

        onClick: {
            dorbittButton: function() {
                $('#btn_clear_form').click(function(){
                    app.Views.kosongkanForm();
                })

                $('#hapus_foto').click(function() {
                    $hizb.upload.ids = [];
                    $hizb.upload.filenames = [];
                    app.Views.defautlFotoRuangan();
                })

                $('#new').click(function() {
                    $hizb.upload.ids = [];
                    $hizb.upload.filenames = [];
                    app.Views.defautlFotoRuangan();
                })
            }
        }*/

    onClick: {
      dorbittButton: function () {
        $("#btn_show_password").click(function () {
          var type = $("#password").attr("type");
          if (type == "password") {
            $("#btn_show_password").html(
              '<i class="bi bi-eye-slash-fill"></i>'
              );
            $("#password").attr("type", "text");
          } else {
            $("#btn_show_password").html('<i class="bi bi-eye-fill"></i>');
            $("#password").attr("type", "password");
          }
        });

        $("#message_modal_close").on("click", function () {
          $("#message_modal").modal("hide");
        });

        $("#btn_endis").click(function () {
          $("#password").val("");
          if ($("#password").is(":disabled")) {
            $("#password").removeAttr("disabled");
            $("#trash_icon").show();
            $("#pencil_icon").hide();
          } else {
            $("#password").attr("disabled", "disabled");
            $("#trash_icon").hide();
            $("#pencil_icon").show();
          }
        });

        $("#btn_modal_max").on("click", function () {
          var el = $("#modal_dialog");
          var hasClass = el.hasClass("modal-lg");
          // console.log(hasClass)

          if (hasClass == true) {
            el.removeClass("modal-lg");
            el.addClass("modal-fullscreen");
          } else {
            el.removeClass("modal-fullscreen");
            el.addClass("modal-lg");
          }
        });

        // $('#dorbitt_open_gallery').click(function() {
        //     var dataImage = $(this).attr('data-image');
        //     $hizb.upload.show_gallery();
        //     $('#modal_gallery').modal('show');
        //     // $hizb.upload.input_id = input_id;
        //     // $hizb.upload.image_id = image_id;
        // })

        // $('#dorbitt_open_gallery2').click(function() {
        //     var dataImage = $(this).attr('data-image');
        //     $hizb.upload.show_gallery2();
        //     $('#modal_gallery').modal('show');
        //     // $hizb.upload.input_id = input_id;
        //     // $hizb.upload.image_id = image_id;
        // })

        // $('#btn_select_file').click(function() {
        //     var ids = [];
        //     var filenames = [];
        //     $('.dorbitt_checkbox_image_gallery:checked').each(function() {
        //         var id = $(this).attr('id');
        //         var filename = $(this).data('name');

        //         ids.push(parseInt(id));
        //         filenames.push(filename)
        //         // console.log(filename)
        //     });

        //     $hizb.upload.ids = ids;
        //     $hizb.upload.filenames = filenames;

        //     app.Views.set_gallery_selected_to_img(filenames)

        //     $('#modal_gallery').modal('hide');
        //     // console.log(ids)
        // })

        $("#dorbitt_tabs .nav-tabs .nav-link").click(function () {
          var urlhash = $(this).attr("data-bs-target");
          window.location.hash = urlhash;
          // console.log(urlhash)
          // document.cookie = urlhash;
          Cookies.set("urlhash", urlhash);
        });

        $("#btn_approved_list").on("click", function () {
          $("#modal_approved_list").modal("show");
        });

        $("#update_profile").on("click", function () {
          app.Controllers.update_profile();
        });

        $(".module-category").on("click", function () {
          // console.log($(this).val());
          localStorage.category_id = $(this).data("value");
          var toUrl =
          $base_url +
          "admin/session/module_category/" +
          $(this).data("value");
          // $hizb.vars.page_previous = toUrl;
          console.log(toUrl);
          window.location.href =
          $base_url +
          "admin/session/module_category/" +
          $(this).data("value");
        });

        $(".dorbitt-login-area #btn_next").on("click", function () {
          var username = $("#username").val();
          var msdb = $("#msdb").val();
          if (username == "" || username == null) {
            $("#alert").html(
              '<div class="alert alert-danger">Username required.</div'
              );
          } else if (msdb == "" || msdb == null) {
            $("#alert").html(
              '<div class="alert alert-danger">Company required.</div'
              );
          } else {
            $(this).addClass("disabled");
            $hizb.routes.auth.username();
          }
        });
      },
      escmButton: function () {
        $("#submit").on("click", function () {
          var msdb = $("#msdb").val();
          localStorage.msdbToken = msdb;
          // console.log(msdb);
        });
      },
    },

    onChange: {
      dorbittCheckBox: function () {
        $(".dorbitt_checkbox").change(function () {
          var element_id = $(this).attr("id");
          if (this.checked) {
            eval("globalVars." + element_id + " = 1");
          } else {
            eval("globalVars." + element_id + " = 0");
          }
        });
      },

      dorbittInput: function () {
        /*// Pindah ke events => onChangeFileGalleryUpload
                $('#file_upload').change(function() {
                    var $id = $('#upload_img_thumbnail');
                    var $filename = $(this)[0].files[0].name;
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $($id).attr('src', e.target.result);
                        alert(e.target.result)
                        $hizb.upload.filename = $filename;
                    };
                    reader.readAsDataURL($(this)[0].files[0]);
                })*/
      },

      dorbittRadio: function () {
        $(".dorbitt-header #rad_approve").on("change", function () {
          $hizb.views.approval.status_detail(1);
        });

        $(".dorbitt-header #rad_pending").on("change", function () {
          $hizb.views.approval.status_detail(3);
        });

        $(".dorbitt-header #rad_reject").on("change", function () {
          $hizb.views.approval.status_detail(2);
        });

        $("#rad_internal").on("change", function () {
          $hizb.vars.rad_external = 0;
        });

        $("#rad_external").on("change", function () {
          $hizb.vars.rad_external = 1;
        });
      },

      // rmChkDetApp: function() {
      //     // var radioApproveOnHeader = $('.dorbitt-detail .rad-approve, .dorbitt-detail .rad-pending, .dorbitt-detail .rad-reject');
      //     $('.dorbitt-detail .rad-approve').attr('checked', false);
      //     $('.dorbitt-detail .rad-pending').attr('checked', false);
      //     $('.dorbitt-detail .rad-reject').attr('checked', false);
      // }

      selectOption: function () {
        // $('#gedung').change(function() {
        //     var maxNum = $(this).find(':selected').attr('data-lantai');
        //     $('#lantai').val("");
        //     $('#lantai').attr('max',maxNum);
        // });
        // $('#module_category').on('click', function() {
        //     // console.log($(this).val());
        //     localStorage.category_id = $(this).data('value');
        //     var toUrl = $base_url + 'admin/session/module_category/' + $(this).data('value');
        //     // $hizb.vars.page_previous = toUrl;
        //     console.log(toUrl);
        //     window.location.href = $base_url + 'admin/session/module_category/' + $(this).data('value');
        // });
      },

      inputFile_onChange_fileUpload: function () {
        $("#file_upload").change(function () {
          var $id = $("#upload_img_thumbnail");
          var $filename = $(this)[0].files[0].name;
          var reader = new FileReader();
          reader.onload = function (e) {
            $($id).attr("src", e.target.result);
            // alert(e.target.result)
            $hizb.upload.filename = $filename;
          };
          reader.readAsDataURL($(this)[0].files[0]);
          console.log("OK");
        });
      },
    },

    gallery: {
      btn_show_gallery: function () {
        $(".btn_show_gallery").on("click", function () {
          $("#modal_gallery").modal("show");
        });
      },
      btn_submit_file_upload: function () {
        $("#btn_submit_file_upload").click(function () {
          var file = $("#file_upload").val();
          if (file != "") {
            $hizb.upload.upload_file_gallery();
          } else {
            alert("Silahkan pilih file terlebih dahulu.");
          }
        });
      },
    },

    form_applicant: function () {
      $("#form_applicant").on("submit", function (event) {
        // alert( "Handler for `submit` called." );
        // $('#modal_loader').modal('show');
        $(this).attr("disabled", true);
        event.preventDefault();
      });
    },

    enter: function (inputID, buttonID) {
      var input = document.getElementById(inputID);
      input.addEventListener("keypress", function (event) {
        if (event.key === "Enter") {
          event.preventDefault();
          document.getElementById(buttonID).click();
        }
      });
    },

    nav_tabs: function () {
      $("nav #nav-tab .nav-link").on("click", function () {
        var id = $(this).attr("id");
        console.log(id);
      });
    },

    btn: {
      toggle_sidebar: function () {
        $(".toggle-sidebar-btn").on("click", function () {
          $hizb.ls.toggle_sidebar();
        });
      },
    },
  },

  helpers: {
    currency: {
      // format number to US dollar
      us: function (data) {
        let USDollar = new Intl.NumberFormat("en-US", {
          minimumFractionDigits: 2,
          // style: 'currency',
          // currency: ' ',
        });

        return USDollar.format(data);
      },

      id: function (data) {
        // let USDollar = new Intl.NumberFormat('en-US', {
        //     minimumFractionDigits: 2,
        //     // style: 'currency',
        //     // currency: ' ',
        // });

        return new Intl.NumberFormat("id-ID", {
          minimumFractionDigits: 2,
          // style: "currency",
          // currency: "IDR"
        }).format(data);

        // return USDollar.format(data);
      },

      id2: function (data) {
        return new Intl.NumberFormat("id-ID", {
          style: "currency",
          currency: "IDR",
        }).format(data);

        // return USDollar.format(data);
      },

      // // format number to British pounds
      // let pounds = Intl.NumberFormat('en-GB', {
      //     style: 'currency',
      //     currency: 'GBP',
      // });

      // // format number to Indian rupee
      // let rupee = new Intl.NumberFormat('en-IN', {
      //     style: 'currency',
      //     currency: 'INR',
      // });

      // // format number to Euro
      // let euro = Intl.NumberFormat('en-DE', {
      //     style: 'currency',
      //     currency: 'EUR',
      // });
    },

    formatTotalPrice: function (data) {
      var field = this.field;
      return (
        "$" +
        data
        .map(function (row) {
          return +row[field].substring(1);
        })
        .reduce(function (sum, i) {
          return sum + i;
        }, 0)
        );
    },

    operateFormatter: function () {
      return [
        // '<a class="like" href="javascript:void(0)" title="Like">',
        //     '<i class="fa fa-heart"></i>',
        // '</a>  ',
        // '<a href="#" id="add" class="remove" data-bs-toggle="modal" data-bs-target="#modal_confirmation">',
        //     '<i class="fa fa-trash"></i>',
        // '</a>   ',
        '<a class="remove" href="javascript:void(0)" title="Remove">',
        '<i class="fa fa-trash"></i>',
        "</a>  ",
        '<a class="edit" href="javascript:void(0)" title="Edit">',
        '<i class="fas fa-edit"></i>',
        "</a>",
      ];
    },

    detailFormatter: function (index, row) {
      var html = [];
      $.each(row, function (key, value) {
        html.push("<p><b>" + key + ":</b> " + value + "</p>");
      });
      return html;
    },

    responseHandler: function (res) {
      $.each(res.rows, function (i, row) {
        row.state = $.inArray(row.id, selections) !== -1;
      });
      return res;
    },

    gedungFormatter: function (index, row) {
      var html = row.kode + " | " + row.name;
      return html;
    },

    rekeningFormatter: function (angka) {
      var number_string = angka.replace(/[^,\d]/g, "").toString(),
      split = number_string.split(","),
      sisa = split[0].length % 3,
      angka_hasil = split[0].substr(0, sisa),
      ribuan = split[0].substr(sisa).match(/\d{3}/gi);

      // tambahkan titik jika yang di input sudah menjadi angka ribuan
      if (ribuan) {
        separator = sisa ? "-" : "";
        angka_hasil += separator + ribuan.join("-");
      }

      angka_hasil =
      split[1] != undefined ? angka_hasil + "," + split[1] : angka_hasil;
      return angka_hasil;
    },

    companyNameFormatter: function (index, row) {
      var html = '<span class="text-muted">' + row.company_name + "</span>";
      return html;
    },

    select2: {
      gentext: function (rows) {
        var data = $.map(rows, function (obj) {
          obj.text = obj.text || obj.name; // replace name with the property used for the text

          return obj;
        });

        return data;
      },

      gentext2: function (rows) {
        var data = $.map(rows, function (obj) {
          obj.id = obj.id || obj.act_number;
          obj.text = obj.text || obj.opr_short_text;

          return obj;
        });

        return data;
      },

      gentext_siteherp: function (rows) {
        var data = $.map(rows, function (obj) {
          obj.id = obj.id || obj.region_code; // replace name with the property used for the text
          obj.text =
            obj.text || obj.region_name + " ( " + obj.region_code + " )"; // replace name with the property used for the text

            return obj;
          });

        return data;
      },

      gen_item__id_name: function (rows) {
        var data = $.map(rows, function (obj) {
          obj.id = obj.id || obj.item_id;
          obj.text = obj.text || obj.item_name + " ( " + obj.item_id + " )";

          return obj;
        });

        return data;
      },
    },
  },

  controllers: {
    show: function (params) {
      // console.log(params)
      var url = $base_url + "/admin/ruangan/show";
      var ali = $globalAjax.ummu(url, params);
      ali
      .done(function (result) {
        var response = JSON.parse(result);
        params.success(response);
        $globFunc.ch_message(response.message);
        app.Controllers.show_gedung();
        app.Controllers.show_roomcateg();
      })
      .fail(function () {
          // An error occurred
      });
    },

    new: function () {
      $("#new").click(function () {
        $("#btnSubmit").attr("onclick", "Routes.create()");
        $("#btn_clear_form").show();
        app.Views.kosongkanForm.apply();
      });
    },

    create: function () {
      var payload = JSON.stringify({
        body: {
          gedung_id: $("#gedung").val(),
          lantai: $("#lantai").val(),
          kode: $("#kode").val(),
          name: $("#name").val(),
          type_id: $("#type").val(),
          room_category_id: $("#category").val(),
          seat: $("#jumlah_seat").val(),
          proyektor: globalVars.proyektor,
          whiteboard: globalVars.whiteboard,
          image_ids: $hizb.upload.ids,
          image_names: $hizb.upload.filenames,
        },
      });

      // console.log(payload)

      var params = {
        type: "post",
        action: "insert",
        data: payload,
        cache: true,
        contentType: "application/json",
        dataType: "json",
      };

      // console.log(params)

      var url = $base_url + "/admin/ruangan/create";
      var ummu = $globalAjax.ummu(url, params);
      ummu
      .done(function (result) {
        console.log(result);
        var response = JSON.parse(result);
        if (response.status == true) {
          $("#InsertModal").modal("hide");
          app.Views.set_value_to_table("insert", response.response);
          $globFunc.ch_message(response.message);
          app.Events.clear_form();
        } else {
          $("#message_title, #text_message").empty();
          var message = response.message;
          var errors = response.errors;
          $("#message_title").html(message);
          for (let index in errors) {
            var $error =
            '<div class="alert alert-danger alert-dismissible fade show" role="alert">' +
            '<i class="bi bi-exclamation-octagon me-1"></i>' +
            errors[index] +
            "</div>";
            $("#text_message").append($error);
          }
          $("#message_modal").modal("show");
        }
      })
      .fail(function () {
          // An error occurred
        console.log(ummu);
      });
    },

    edit: function (row, index) {
      $("#btnSubmit").attr("onclick", "Routes.update(" + row.id + ");");
      globalVars.dataIndex = index;
      $("#btnSubmit").html("Save changes");
      $("#btn_clear_form").hide();
      $("#InsertModal").modal("toggle");
      app.Views.kosongkanForm.apply();
      app.Views.set_value_to_form(row, index);
    },

    update: function (id) {
      var payload = JSON.stringify({
        body: {
          gedung_id: $("#gedung").val(),
          lantai: $("#lantai").val(),
          kode: $("#kode").val(),
          name: $("#name").val(),
          type_id: $("#type").val(),
          room_category_id: $("#category").val(),
          seat: $("#jumlah_seat").val(),
          proyektor: globalVars.proyektor,
          whiteboard: globalVars.whiteboard,
          image_ids: $hizb.upload.ids,
          image_names: $hizb.upload.filenames,
        },
      });

      var params = {
        type: "put",
        action: "update",
        data: payload,
        cache: true,
        contentType: "application/json",
        dataType: "json",
      };

      var url = $base_url + "admin/ruangan/update/" + id;
      var ummu = $globalAjax.ummu(url, params);

      ummu
      .done(function (result) {
        console.log(result);
        var response = JSON.parse(result);
        if (response.status == true) {
          $("#InsertModal").modal("hide");
          app.Views.set_value_to_table("update", id);
          $globFunc.ch_message(response.message);
        } else {
          $("#message_title, #text_message").empty();
          var message = response.message;
          var errors = response.errors;
          $("#message_title").html(message);
          for (let index in errors) {
            var $error =
            '<div class="alert alert-danger alert-dismissible fade show" role="alert">' +
            '<i class="bi bi-exclamation-octagon me-1"></i>' +
            errors[index] +
            "</div>";
            $("#text_message").append($error);
          }
          $("#message_modal").modal("show");
        }
      })
      .fail(function () {
          // An error occurred
        console.log(ummu);
      });

      // console.log(JSON.parse(payload))
    },

    delete: function (id) {
      // controllers.delete(id)
      var params = {
        type: "delete",
        action: "delete",
        data: null,
        cache: true,
        contentType: "application/json",
        dataType: "json",
      };

      var url = $base_url + "admin/ruangan/delete/" + id;
      var ummu = $globalAjax.ummu(url, params);

      ummu
      .done(function (result) {
        var response = JSON.parse(result);
        if (response.status == true) {
          $globFunc.ch_message(response.message);
          $table.bootstrapTable("removeByUniqueId", id);
        } else {
          $("#modal_alert_input").html("");
          var errors = response.errors;
          $("#modal_alert_input").addClass("bg-danger");
          for (let index in errors) {
            $("#modal_alert_input").append("<li>" + errors[index] + "</li>");
          }
          $("#modal_alert_input").fadeIn().delay(3000).fadeOut();
        }

        $("#modal_confirmation").modal("hide");
      })
      .fail(function () {
          // An error occurred
        console.log(ummu);
      });
    },

    multiple_delete() {
      var payload = JSON.stringify({
        body: {
          ids: $globFunc.getIdSelections(),
        },
      });

      var params = {
        type: "delete",
        action: "multiple_delete",
        data: payload,
        cache: true,
        contentType: "application/json",
        dataType: "json",
      };

      var url = $base_url + "admin/ruangan/delete";
      var ummu = $globalAjax.ummu(url, params);

      ummu
      .done(function (result) {
        var response = JSON.parse(result);
        if (response.status == true) {
          $globFunc.ch_message(response.message);
          $table.bootstrapTable("remove", {
            field: "id",
            values: $globFunc.getIdSelections(),
          });
          $remove.prop("disabled", true);
        } else {
          $("#modal_alert_input").html("");
          var errors = response.errors;
          $("#modal_alert_input").addClass("bg-danger");
          for (let index in errors) {
            $("#modal_alert_input").append("<li>" + errors[index] + "</li>");
          }
          $("#modal_alert_input").fadeIn().delay(3000).fadeOut();
        }
        $("#modal_confirmation_multiple_delete").modal("hide");
      })
      .fail(function () {
          // An error occurred
        console.log(ummu);
      });
    },

    _import: function () {
      // if ($('#file_import').val()) {
      //     $('#ImportModal').modal('toggle');
      //     Controllers._import()
      // }else{
      //     $('#modal_alert_import').html("File required")
      // }
    },

    show_gedung: function () {
      var params = {
        type: "get",
        action: "get",
        data: {
          limit: 0,
          offset: 0,
          sort: "kode",
          order: "asc",
          search: "",
        },
        cache: true,
        contentType: "application/json",
        dataType: "json",
      };
      var url = $base_url + "/admin/ruangan/show_gedung";
      var ali = $globalAjax.ummay(url, params);
      ali
      .done(function (result) {
        var response = JSON.parse(result);
          // console.log(response.rows)
        var params2 = {
          rows: response.rows,
          element_id: "gedung",
          kode: 1,
        };

          // $globFunc.set_value_to_option(response.rows,'gedung',1)
          // $globFunc.set_value_to_option3(params2)
        app.Views.set_value_to_option_gedung(params2);
      })
      .fail(function () {
          // An error occurred
      });
    },

    show_roomcateg: function () {
      var params = {
        type: "get",
        action: "get",
        data: {
          limit: 0,
          offset: 0,
          sort: "id",
          order: "desc",
          search: "",
        },
        cache: true,
        contentType: "application/json",
        dataType: "json",
      };
      var url = $base_url + "/admin/ruangan/show_roomcateg";
      var ali = $globalAjax.ummay(url, params);
      ali
      .done(function (result) {
        var response = JSON.parse(result);
          // console.log(response.rows)
        $globFunc.set_value_to_option(response.rows, "category", 0);
      })
      .fail(function () {
          // An error occurred
      });
    },
  },

  auth: {
    login: function (withMsdb = null) {
      $("#btn_login").on("click", function () {
        var username = $("#username").val(),
        password = $("#password").val(),
        msdb = $("#msdb").val();

        if (withMsdb == "withMsdb") {
          if (msdb == null) {
            alert("Silahkan pilih company.");
          } else {
            var vars =
            "?username=" +
            username +
            "&password=" +
            password +
            "&msdb=" +
            msdb,
            body = {
              body: {
                username: username,
                password: password,
                msdb: msdb,
              },
            },
            payload = {
              username: username,
              password: password,
              msdb: msdb,
            };
          }
        } else {
          var vars = "?username=" + username + "&password=" + password,
          body = {
            body: {
              username: username,
              password: password,
            },
          },
          payload = {
            username: username,
            password: password,
          };
        }

        var url = $hizb.vars.base_url + "auth/login/create" + vars;
        var params = {
          url: url,
          type: "post",
          action: "create",
          data: null,
          cache: true,
          contentType: "application/json",
          dataType: "json",
        };

        console.log(params);

        // var ummu = $hizb.ajax.auth.login(params);
        // ummu.done(function(result) {
        //     console.log(result)
        //     var response = result;
        //     if (response.status == true) {
        // //     $('#alert').html('<div class="alert alert-success">'+response.messages+'</div>');
        // //     $('#username_area, #btn_next').addClass('collapse');
        // //     $('#otp_area, #btn_verify_otp').removeClass('collapse');
        // //     $('#username_change, #username_change2').val($('#username').val());
        // //     $('#alert').html('');
        //         window.location.replace($hizb.vars.base_url + 'admin');
        //     }else{
        // //     $('#alert').html('<div class="alert alert-danger">'+response.errors+'</div>');
        // //     if (response.errors == 'You have already created an otp before.') {
        // //         $('#username_area, #btn_next').addClass('collapse');
        // //         $('#otp_area, #btn_verify_otp').removeClass('collapse');
        // //         $('#username_change, #username_change2').val($('#username').val());
        // //     }
        //     }
        // // $('#btn_next').removeClass('disabled');
        //     setTimeout( function() {
        //         $('#modal_loader').modal('hide');
        //     }, 1000 );
        // }).fail(function() {
        // // An error occurred
        //     console.log(ummu)
        // });
      });
    },

    login_with_msdb: function () {
      $("#btn_login").on("click", function () {
        var username = $("#username").val(),
        password = $("#password").val(),
        msdb = $("#msdb").val();

        if (msdb == null) {
          alert("Silahkan pilih company.");
        } else {
          var vars =
          "?username=" +
          username +
          "&password=" +
          password +
          "&msdb=" +
          msdb,
          body = {
            body: {
              username: username,
              password: password,
              msdb: msdb,
            },
          },
          payload = {
            username: username,
            password: password,
            msdb: msdb,
          };

          var url = $hizb.vars.base_url + "auth/login/create" + vars;
          var params = {
            url: url,
            type: "post",
            action: "create",
            data: null,
            cache: true,
            contentType: "application/json",
            dataType: "json",
          };

          // console.log(params);

          var ummu = $hizb.ajax.auth.login(params);
          ummu
          .done(function (result) {
              // console.log(result)
            var response = result;
            if (response.status == true) {
              $("#alert").html(
                '<div class="alert alert-success">' +
                response.message +
                "</div>"
                );
              window.location.replace($hizb.vars.base_url + "admin");
            } else {
              $("#alert").html(
                '<div class="alert alert-danger">' +
                response.message +
                "</div>"
                );
            }
            setTimeout(function () {
              $("#modal_loader").modal("hide");
            }, 1000);
          })
          .fail(function () {
              // An error occurred
            console.log(ummu);
          });
        }
      });
    },
  },

  ajax: {
    auth: {
      login: function (params) {
        // console.log(params.data);
        var jqXHR = $.ajax({
          url: params.url,
          method: params.type,
          timeout: 0,
          headers: {
            "Content-Type": params.contentType,
          },
          data: params.data,
          prossesing: true,
          language: {
            loadingRecords: "&nbsp;",
            processing: '<div class="spinner"></div>',
          },
          beforeSend: function (e) {
            $("#modal_loader2").modal("show");
          },
          complete: function () {
            //
          },
          success: function (response) {
            // console.log(response)
            setTimeout(function () {
              $(".modal-loader2").modal("hide");
            }, 1000);
          },
          error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.responseText);
            $("#modal_loader2").modal("hide");
          },
        });

        return jqXHR;
      },
    },

    show0: function (url) {
      // console.log(payload);
      var jqXHR = $.ajax({
        url: url,
        method: "GET",
        timeout: 0,
        headers: {
          "Content-Type": "application/json",
        },
        // "data": payload.data,
        prossesing: true,
        language: {
          loadingRecords: "&nbsp;",
          processing: '<div class="spinner"></div>',
        },
        beforeSend: function (e) {
          // // if (payload.type == 'delete') {
          // //     $('#loader_delete').show()
          // // }else{
          // //     $('#modal_loader_input').show()
          // // }
          // if (payload.action == 'delete') {
          //     $('#loader_delete').show()
          // }else if (payload.action == 'multiple_delete') {
          //     $('#loader_mulitple_delete').show()
          // }else if (payload.action == 'insert' || payload.action == 'update') {
          //     $('#modal_loader_input').show()
          // }
          // if(e && e.overrideMimeType) {
          //     e.overrideMimeType('application/jsoncharset=UTF-8')
          // }
          // $('#response_message, #response_message_modal, #response_message_modal_modal').removeClass('text-success msg_animation');
        },
        complete: function () {
          // if (payload.action == 'delete') {
          //     $('#loader_delete').hide()
          // }else if (payload.action == 'multiple_delete') {
          //     $('#loader_mulitple_delete').hide()
          // }else if (payload.action == 'insert' || payload.action == 'update') {
          //     $('#modal_loader_input').hide()
          // }
          // // $('#loader_delete').hide()
          // // $('#loader_mulitple_delete').hide()
          // // $('#modal_loader_input').hide()
        },
        success: function (response) {
          // console.log(response)
        },
        error: function (xhr, ajaxOptions, thrownError) {
          alert(xhr.responseText);
        },
      });

      return jqXHR;
    },

    ummu: function (url, payload) {
      // console.log(payload);
      var jqXHR = $.ajax({
        url: url,
        method: payload.type,
        timeout: 0,
        headers: {
          "Content-Type": payload.contentType,
        },
        data: payload.data,
        prossesing: true,
        language: {
          loadingRecords: "&nbsp;",
          processing: '<div class="spinner"></div>',
        },
        beforeSend: function (e) {
          $("#modal_loader").modal("show");
          // if (payload.type == 'delete') {
          //     $('#loader_delete').show()
          // }else{
          //     $('#modal_loader_input').show()
          // }

          if (payload.action == "delete") {
            $("#loader_delete").show();
          } else if (payload.action == "multiple_delete") {
            $("#loader_mulitple_delete").show();
          } else if (payload.action == "insert" || payload.action == "update") {
            $("#modal_loader_input").show();
          }

          if (e && e.overrideMimeType) {
            e.overrideMimeType("application/jsoncharset=UTF-8");
          }
          $(
            "#response_message, #response_message_modal, #response_message_modal_modal"
            ).removeClass("text-success msg_animation");
        },
        complete: function () {
          if (payload.action == "delete") {
            $("#loader_delete").hide();
          } else if (payload.action == "multiple_delete") {
            $("#loader_mulitple_delete").hide();
          } else if (payload.action == "insert" || payload.action == "update") {
            $("#modal_loader_input").hide();
          }
          // $('#loader_delete').hide()
          // $('#loader_mulitple_delete').hide()
          // $('#modal_loader_input').hide()
        },
        success: function (response) {
          // console.log(response)
        },
        error: function (xhr, ajaxOptions, thrownError) {
          alert(xhr.responseText);
        },
      });

      return jqXHR;
    },

    ummu2: function (params) {
      // console.log(payload);
      var jqXHR = $.ajax({
        url: params.url,
        method: params.type,
        timeout: 0,
        headers: {
          "Content-Type": params.contentType,
        },
        data: params.data,
        prossesing: true,
        language: {
          loadingRecords: "&nbsp;",
          processing: '<div class="spinner"></div>',
        },
        beforeSend: function (e) {
          $("#modal_loader").modal("show");
          // if (payload.type == 'delete') {
          //     $('#loader_delete').show()
          // }else{
          //     $('#modal_loader_input').show()
          // }

          if (params.action == "delete") {
            $("#loader_delete").show();
          } else if (params.action == "multiple_delete") {
            $("#loader_mulitple_delete").show();
          } else if (params.action == "insert" || params.action == "update") {
            $("#modal_loader_input").show();
          }

          if (e && e.overrideMimeType) {
            e.overrideMimeType("application/jsoncharset=UTF-8");
          }
          $(
            "#response_message, #response_message_modal, #response_message_modal_modal"
            ).removeClass("text-success msg_animation");
        },
        complete: function () {
          if (params.action == "delete") {
            $("#loader_delete").hide();
          } else if (params.action == "multiple_delete") {
            $("#loader_mulitple_delete").hide();
          } else if (params.action == "insert" || params.action == "update") {
            $("#modal_loader_input").hide();
          }
          // $('#loader_delete').hide()
          // $('#loader_mulitple_delete').hide()
          // $('#modal_loader_input').hide()

          // console.log(response)
          setTimeout(function () {
            $(".modal-loader").modal("hide");
          }, 1000);
        },
        success: function (response) {
          //
        },
        error: function (xhr, ajaxOptions, thrownError) {
          alert(xhr.responseText);
          $("#modal_loader").modal("hide");
        },
      });

      return jqXHR;
    },

    ummu3: function (params) {
      // console.log(params.data);
      var jqXHR = $.ajax({
        url: params.url,
        method: params.type,
        timeout: 0,
        headers: {
          "Content-Type": params.contentType,
        },
        data: params.data,
        prossesing: true,
        language: {
          loadingRecords: "&nbsp;",
          processing: '<div class="spinner"></div>',
        },
        beforeSend: function (e) {
          $("#modal_loader").modal("show");
        },
        complete: function () {
          //
        },
        success: function (response) {
          // console.log(response)
          setTimeout(function () {
            $(".modal-loader").modal("hide");
          }, 1000);
        },
        error: function (xhr, ajaxOptions, thrownError) {
          alert(xhr.responseText);
          $("#modal_loader").modal("hide");
        },
      });

      return jqXHR;
    },

    /*
     * page_url otomatis dari ummu.vars
     * dinamis modal_loader
     * */
    ummu4: function (params) {
      var jqXHR = $.ajax({
        url: $hizb.vars.page_url + params.function,
        method: params.type,
        timeout: 0,
        headers: {
          "Content-Type": params.contentType,
        },
        data: params.data,
        prossesing: true,
        language: {
          loadingRecords: "&nbsp;",
          processing: '<div class="spinner"></div>',
        },
        beforeSend: function (e) {
          if (params.loader == true) {
            $("#modal_loader").modal("show");
          }
        },
        complete: function () {
          //
        },
        success: function (response) {
          // console.log(response)
          setTimeout(function () {
            $(".modal-loader").modal("hide");
          }, 1000);
        },
        error: function (xhr, ajaxOptions, thrownError) {
          alert(xhr.responseText);
          $("#modal_loader").modal("hide");
        },
      });

      return jqXHR;
    },

    /**
     * page_url manual dari params
     * dinamis modal_loader
     * */
    ummu5: function (params) {
      // console.log(params.data);
      var jqXHR = $.ajax({
        url: params.url,
        method: params.type,
        timeout: 0,
        headers: {
          "Content-Type": params.contentType,
        },
        data: params.data,
        prossesing: true,
        language: {
          loadingRecords: "&nbsp;",
          processing: '<div class="spinner"></div>',
        },
        beforeSend: function (e) {
          if (params.loader == true) {
            $("#modal_loader").modal("show");
          }
        },
        complete: function () {
          //
        },
        success: function (response) {
          // console.log(response)
          setTimeout(function () {
            $(".modal-loader").modal("hide");
          }, 1000);
        },
        error: function (xhr, ajaxOptions, thrownError) {
          alert(xhr.responseText);
          $("#modal_loader").modal("hide");
        },
      });

      return jqXHR;
    },

    /**
     * body = form-data 
     * url = otomatis dari $hizb.vars.page_url
     * method = custom
    * */
    ummu6: function (params) {
      return $.ajax({
        url: $hizb.vars.page_url + params.function,
        method: params.method,
        timeout: 0,
        processData: false,
        mimeType: "multipart/form-data",
        contentType: false,
        data: params.data,
        beforeSend: function (e) {
          if (params.loader == true) {
            $("#modal_loader").modal("show");
          }

          if (e && e.overrideMimeType) {
            e.overrideMimeType("application/jsoncharset=UTF-8");
          }
        },
        complete: function () {
          setTimeout(function () {
            $(".modal-loader").modal("hide");
          }, 1000);
        },
        error: function (xhr, ajaxOptions, thrownError) {
          alert(xhr.responseText);
        },
      });
    },

    /**
     * body = form-data 
     * url = otomatis dari $hizb.vars.page_url
     * method = POST* */
    ummu7: function (params) {
      return $.ajax({
        url: $hizb.vars.page_url + params.function,
        method: "POST",
        timeout: 0,
        processData: false,
        mimeType: "multipart/form-data",
        contentType: false,
        data: params.data,
        beforeSend: function (e) {
          if (params.loader == true) {
            $("#modal_loader").modal("show");
          }

          if (e && e.overrideMimeType) {
            e.overrideMimeType("application/jsoncharset=UTF-8");
          }
        },
        complete: function () {
          setTimeout(function () {
            $(".modal-loader").modal("hide");
          }, 1000);
        },
        error: function (xhr, ajaxOptions, thrownError) {
          alert(xhr.responseText);
        },
      });
    },

    ummay: function (url, payload) {
      // console.log(payload);
      var jqXHR = $.ajax({
        url: url,
        method: payload.type,
        timeout: 0,
        headers: {
          "Content-Type": payload.contentType,
        },
        data: payload.data,
        beforeSend: function (e) {
          // if (payload.action == 'delete') {
          //     $('#loader_delete').show()
          // }else if (payload.action == 'multiple_delete') {
          //     $('#loader_mulitple_delete').show()
          // }else if (payload.action == 'insert' || payload.action == 'update') {
          //     $('#modal_loader_input').show()
          // }
          $(".modal-loader").modal("show");

          if (e && e.overrideMimeType) {
            e.overrideMimeType("application/jsoncharset=UTF-8");
          }
          // $('#response_message').removeClass('text-success msg_animation');
        },
        complete: function () {
          if (payload.action == "delete") {
            $("#loader_delete").hide();
          } else if (payload.action == "multiple_delete") {
            $("#loader_mulitple_delete").hide();
          } else if (payload.action == "insert" || payload.action == "update") {
            $("#modal_loader_input").hide();
          }

          setTimeout(function () {
            $(".modal-loader").modal("hide");
          }, 1000);
        },
        success: function (response) {
          // console.log(response)
        },
        error: function (xhr, ajaxOptions, thrownError) {
          alert(xhr.responseText);
        },
      });

      return jqXHR;
    },

    ummay2: function (url, payload) {
      // console.log(payload);
      var jqXHR = $.ajax({
        url: url,
        method: payload.type,
        timeout: 0,
        headers: {
          "Content-Type": payload.contentType,
          'Msdb-Token': window.settings.msdbToken || null,
          'Authorization': window.settings.token || null
        },
        data: payload.data,
        beforeSend: function (e) {
          // if (payload.action == 'delete') {
          //     $('#loader_delete').show()
          // }else if (payload.action == 'multiple_delete') {
          //     $('#loader_mulitple_delete').show()
          // }else if (payload.action == 'insert' || payload.action == 'update') {
          //     $('#modal_loader_input').show()
          // }
          $(".modal-loader").modal("show");

          if (e && e.overrideMimeType) {
            e.overrideMimeType("application/jsoncharset=UTF-8");
          }
          // $('#response_message').removeClass('text-success msg_animation');
        },
        complete: function () {
          if (payload.action == "delete") {
            $("#loader_delete").hide();
          } else if (payload.action == "multiple_delete") {
            $("#loader_mulitple_delete").hide();
          } else if (payload.action == "insert" || payload.action == "update") {
            $("#modal_loader_input").hide();
          }

          setTimeout(function () {
            $(".modal-loader").modal("hide");
          }, 1000);
        },
        success: function (response) {
          // console.log(response)
        },
        error: function (xhr, ajaxOptions, thrownError) {
          alert(xhr.responseText);
        },
      });

      return jqXHR;
    },

    ummuUpload: function () {
      var formData = new FormData();
      formData.append("file_mygallery", $("#file_mygallery")[0].files[0]);
      return $.ajax({
        url: $base_url + "mygallery/create",
        method: "POST",
        timeout: 0,
        processData: false,
        mimeType: "multipart/form-data",
        contentType: false,
        data: formData,
        beforeSend: function (e) {
          $("#modal_loader").modal("show");
          if (e && e.overrideMimeType) {
            e.overrideMimeType("application/jsoncharset=UTF-8");
          }
        },
        complete: function () {
          setTimeout(function () {
            $(".modal-loader").modal("hide");
          }, 1000);
        },
        error: function (xhr, ajaxOptions, thrownError) {
          alert(xhr.responseText);
        },
      });
    },

    show: function (url, payload) {
      console.log(payload);
      // var data = params.data;
      // // console.log(data)

      // if (data.sort) {
      //     var sort = data.sort;
      // }else{
      //     var sort = "id"
      // }

      // if (data.order) {
      //     var order = data.order;
      // }else{
      //     var order = "desc"
      // }

      // var jqXHR = $.ajax({
      //     "url": url + "?limit=" + data.limit + "&offset=" + data.offset + "&sort=" + sort + "&order=" + order + "&search=" + data.search,
      //     "method": "GET",
      //     "timeout": 0,
      // });

      // return jqXHR;

      var jqXHR = $.ajax({
        url: url,
        method: payload.type,
        timeout: 0,
        headers: {
          "Content-Type": payload.contentType,
        },
        data: payload.data,
        beforeSend: function (e) {
          $("#modal_loader_input").show();
          if (e && e.overrideMimeType) {
            e.overrideMimeType("application/jsoncharset=UTF-8");
          }
          // $('#response_message').html('');
          $("#response_message").removeClass("text-success msg_animation");
        },
        complete: function () {
          setTimeout(function () {
            $("#modal_loader").modal("hide");
          }, 1000);
        },
        success: function (response) {
          // console.log(response)
        },
        error: function (xhr, ajaxOptions, thrownError) {
          alert(xhr.responseText);
        },
      });

      return jqXHR;
    },

    findAll: function (params, url) {
      var data = params.data;
      // console.log(data)

      if (data.sort) {
        var sort = data.sort;
      } else {
        var sort = "id";
      }

      if (data.order) {
        var order = data.order;
      } else {
        var order = "desc";
      }

      var jqXHR = $.ajax({
        url:
        $base_url +
        url +
        "/findAll?limit=" +
        data.limit +
        "&offset=" +
        data.offset +
        "&sort=" +
        sort +
        "&order=" +
        order +
        "&search=" +
        data.search,
        method: "GET",
        timeout: 0,
      });

      return jqXHR;
    },

    save: function (url, method, payload) {
      console.log(payload);
      // var jqXHR = $.ajax({
      //     "url": url,
      //     "method": method,
      //     "timeout": 0,
      //     "headers": {
      //         "Content-Type": "application/json",
      //     },
      //     "data": payload,
      //     beforeSend: function(e) {
      //         $('#modal_loader_input').show()
      //         if(e && e.overrideMimeType) {
      //             e.overrideMimeType('application/jsoncharset=UTF-8')
      //         }
      //         $('#response_message').html('');
      //         $('#response_message').removeClass('text-success msg_animation');
      //     },
      //     complete: function(){
      //         $('#modal_loader_input').hide()
      //     },
      //     success: function(response){
      //         // console.log(response)
      //     },
      //     error: function (xhr, ajaxOptions, thrownError) {
      //         alert(xhr.responseText);
      //     }
      // });

      // return jqXHR;
    },

    create: function (url, payload) {
      var jqXHR = $.ajax({
        url: url,
        method: "POST",
        timeout: 0,
        headers: {
          "Content-Type": "application/json",
        },
        data: payload,
        beforeSend: function (e) {
          $("#modal_loader_input").show();
          if (e && e.overrideMimeType) {
            e.overrideMimeType("application/jsoncharset=UTF-8");
          }
          $("#response_message").html("");
          $("#response_message").removeClass("text-success msg_animation");
        },
        complete: function () {
          $("#modal_loader_input").hide();
        },
        success: function (response) {
          // console.log(response)
        },
        error: function (xhr, ajaxOptions, thrownError) {
          alert(xhr.responseText);
        },
      });

      return jqXHR;
    },

    update: function (url, payload) {
      var jqXHR = $.ajax({
        url: url,
        method: "PUT",
        timeout: 0,
        headers: {
          "Content-Type": "application/json",
        },
        data: payload,
        beforeSend: function (e) {
          $("#modal_loader_input").show();
          if (e && e.overrideMimeType) {
            e.overrideMimeType("application/jsoncharset=UTF-8");
          }
          $("#response_message").html("");
          $("#response_message").removeClass("text-success msg_animation");
        },
        complete: function () {
          $("#modal_loader_input").hide();
        },
        success: function (response) {
          // console.log(response)
        },
        error: function (xhr, ajaxOptions, thrownError) {
          alert(xhr.responseText);
        },
      });

      return jqXHR;
    },

    delete: function (url, params) {
      //
    },

    multiple_delete(url, rows) {
      // console.log(rows)

      $("#btn_approve").prop("disabled", true);
      $("#modal_loader_approval").show();

      var r = [];
      $.each(rows, function (index, value) {
        r[index] = {};

        r[index] = value.id;
        // r[index].appv_remark = "by multiple approve";
        // r[index].doc_number = value.doc_code;

        // var d = [];
        // $.each(value.detail, function( index2, value2) {
        //     d[index2] = {};

        //     // d[index2].status = 1;
        //     // d[index2].comment = "by multiple approve";
        //     // d[index2].part_code = value2.Prod_code;
        //     // d[index2].part_qty = value2.part_qty;
        //     // d[index2].harga = value2.harga;
        //     // d[index2].disc = value2.Disc;
        //     // d[index2].nomer = value2.nomer;
        //     d[index2].id = value2.id;
        // })

        // r[index].details = d;
      });

      var payload = JSON.stringify({
        body: {
          ids: r,
        },
      });

      console.log(payload);

      // var payload = JSON.stringify(
      // {
      //     "body": {
      //         "ids": $hizb.func.getIdSelections()
      //     }
      // });

      var params = {
        type: "delete",
        action: "multiple_delete",
        data: payload,
        cache: true,
        contentType: "application/json",
        dataType: "json",
      };

      // // var url = $base_url + "admin/ruangan/delete";
      var ummu = $hizb.ajax.ummay(url, params);
      ummu
      .done(function (result) {
        var response = JSON.parse(result);
          // if (response.status==true) {
          //     $globFunc.ch_message(response.message);
          //     $table.bootstrapTable('remove', {
          //         field: 'id',
          //         values: $globFunc.getIdSelections()
          //     })
          //     $remove.prop('disabled', true)
          // }else{
          //     $('#modal_alert_input').html("");
          //     var errors = response.errors;
          //     $('#modal_alert_input').addClass('bg-danger');
          //     for(let index in errors){
          //         $('#modal_alert_input').append("<li>"+errors[index]+"</li>");
          //     }
          //     $('#modal_alert_input').fadeIn().delay(3000).fadeOut();
          // }
          // $('#modal_confirmation_multiple_delete').modal('hide')
      })
      .fail(function () {
          // An error occurred
        console.log(ummu);
      });
    },

    wilayahIndonesia: {
      getRegencies: function (provincie_id, auto_slected) {
        $.ajax({
          type: "GET",
          url:
          $base_url +
          "admin/referensi/wilayah_indonesia/regencies/" +
          provincie_id,
          dataType: "JSON",
          contentType: false,
          processData: false,
        })
        .done(function (result) {
          var data = result;
          console.log(data);
          for (let index in data) {
            if (data[index].id == auto_slected) {
              var selected_auto = "selected";
            } else {
              var selected_auto = "";
            }
            $("#regencies").append(
              "<option value='" +
              data[index].id +
              "'" +
              selected_auto +
              " >" +
              data[index].name +
              "</option>"
              );
          }
          $("#regencies").attr("disabled", false);

          $("#regencies").select2({
            dropdownParent: $("#InsertModal"),
            theme: "bootstrap4",
          });
        })
        .fail(function () {
            // An error occurred
        });
      },

      getDistricts: function (regencie_id, auto_slected) {
        $.ajax({
          type: "GET",
          url:
          $base_url +
          "admin/referensi/wilayah_indonesia/districts/" +
          regencie_id,
          dataType: "JSON",
          contentType: false,
          processData: false,
        })
        .done(function (result) {
          var data = result;
          console.log(data);
          for (let index in data) {
            if (data[index].id == auto_slected) {
              var selected_auto = "selected";
            } else {
              var selected_auto = "";
            }
            $("#districts").append(
              "<option value='" +
              data[index].id +
              "'" +
              selected_auto +
              ">" +
              data[index].name +
              "</option>"
              );
          }
          $("#districts").attr("disabled", false);

          $("#districts").select2({
            dropdownParent: $("#InsertModal"),
            theme: "bootstrap4",
          });
        })
        .fail(function () {
            // An error occurred
        });
      },

      getVillages: function (district_id, auto_slected) {
        $.ajax({
          type: "GET",
          url:
          $base_url +
          "admin/referensi/wilayah_indonesia/villages/" +
          district_id,
          dataType: "JSON",
          contentType: false,
          processData: false,
        })
        .done(function (result) {
          var data = result;
          console.log(data);
          for (let index in data) {
            if (data[index].id == auto_slected) {
              var selected_auto = "selected";
            } else {
              var selected_auto = "";
            }
            $("#villages").append(
              "<option value='" +
              data[index].id +
              "'" +
              selected_auto +
              ">" +
              data[index].name +
              "</option>"
              );
          }
          $("#villages").attr("disabled", false);

          $("#villages").select2({
            dropdownParent: $("#InsertModal"),
            theme: "bootstrap4",
          });
        })
        .fail(function () {
            // An error occurred
        });
      },
    },

    masterData: {},

    getRefStatusMahasiswa: function () {
      var jqXHR = $.ajax({
        type: "GET",
        url: $base_url + "admin/referensi/get_ref_status_mahasiswa/",
        dataType: "JSON",
        contentType: false,
        processData: false,
      });

      return jqXHR;
    },

    getRefJenisTinggal: function () {
      var jqXHR = $.ajax({
        type: "GET",
        url: $base_url + "admin/referensi/jenis_tinggal/",
        dataType: "JSON",
        contentType: false,
        processData: false,
      });

      return jqXHR;
    },

    getRefAlatTransportasi: function () {
      var jqXHR = $.ajax({
        type: "GET",
        url: $base_url + "admin/referensi/alat_transportasi/",
        dataType: "JSON",
        contentType: false,
        processData: false,
      });

      return jqXHR;
    },

    getRefPekerjaan: function () {
      var jqXHR = $.ajax({
        type: "GET",
        url: $base_url + "admin/referensi/pekerjaan/",
        dataType: "JSON",
        contentType: false,
        processData: false,
      });

      return jqXHR;
    },

    getRefPenghasilan: function () {
      var jqXHR = $.ajax({
        type: "GET",
        url: $base_url + "admin/referensi/penghasilan/",
        dataType: "JSON",
        contentType: false,
        processData: false,
      });

      return jqXHR;
    },

    getRefPendidikan: function () {
      var jqXHR = $.ajax({
        type: "GET",
        url: $base_url + "admin/referensi/pendidikan/",
        dataType: "JSON",
        contentType: false,
        processData: false,
      });

      return jqXHR;
    },

    getProdi: function () {
      var jqXHR = $.ajax({
        type: "GET",
        url:
        $base_url +
        "admin/prodi/findAll?limit=10&offset=0&sort=id&order=desc&search=",
        dataType: "JSON",
        contentType: false,
        processData: false,
      });

      return jqXHR;
    },

    aumImport: function (url) {
      var form = new FormData();
      form.append("file", $("#file_import")[0].files[0]);
      // console.log(form);

      var settings = {
        url: url,
        method: "POST",
        timeout: 0,
        headers: {
          // "Content-Type": "multipart/form-data"
        },
        processData: false,
        mimeType: "multipart/form-data",
        contentType: false,
        data: form,
        beforeSend: function (e) {
          $("#modal_import #loader").show();
        },
        complete: function () {
          $("#modal_import #loader").hide();
        },
        success: function (response) {
          console.log(response);
        },
        error: function (xhr, ajaxOptions, thrownError) {
          alert(xhr.responseText);
        },
      };

      return $.ajax(settings);
    },

    aumImport2: function (url) {
      var form = new FormData();
      form.append("file", $("#file_import")[0].files[0]);
      form.append("periode_id", $("#periode").val());
      // console.log(form);

      var settings = {
        url: url,
        method: "POST",
        timeout: 0,
        headers: {
          // "Content-Type": "multipart/form-data"
        },
        processData: false,
        mimeType: "multipart/form-data",
        contentType: false,
        data: form,
        beforeSend: function (e) {
          $("#modal_import2 #loader").show();
        },
        complete: function () {
          $("#modal_import2 #loader").hide();
        },
        success: function (response) {
          console.log(response);
        },
        error: function (xhr, ajaxOptions, thrownError) {
          alert(xhr.responseText);
        },
      };

      return $.ajax(settings);
    },

    payroll: {
      payslip_periode: {
        create: function () {
          //
        },
      },
    },

    mygallery: {
      photos: {
        upload: function () {
          var formData = new FormData();
          formData.append("file_upload", $("#file_upload")[0].files[0]);
          formData.append("file_description", $("#file_description").val());
          return $.ajax({
            url: $base_url + "mygallery/photos/create",
            method: "POST",
            timeout: 0,
            processData: false,
            mimeType: "multipart/form-data",
            contentType: false,
            data: formData,
            beforeSend: function (e) {
              $("#modal_loader").modal("show");
              if (e && e.overrideMimeType) {
                e.overrideMimeType("application/jsoncharset=UTF-8");
              }
            },
            complete: function () {
              setTimeout(function () {
                $(".modal-loader").modal("hide");
              }, 1000);
            },
            error: function (xhr, ajaxOptions, thrownError) {
              alert(xhr.responseText);
            },
          });
        },
      },
    },

    hazard_report: {
      release: function () {
        var rows = $hizb.vars.rows;
        var url = globalVar.pageUrl;
        var r = [];
        $.each(rows, function (index, value) {
          r[index] = {};
          r[index] = value.id;
        });

        var payload = JSON.stringify({
          body: {
            ids: r,
          },
        });

        var params = {
          url: url + "release",
          type: "put",
          // "action": "insert",
          data: payload,
          cache: true,
          contentType: "application/json",
          dataType: "json",
        };

        // console.log(params)

        $("#text_loader").html("Release in process...");
        var ummu = $hizb.ajax.ummu3(params);
        $("#modal_release_confirm").modal("hide");
        ummu
        .done(function (result) {
            // var response = JSON.parse(result);
            // console.log(result)
          table.rows(".selected").remove().draw();
          $hizb.views.hazard_report.layout();
            // $hizb.dt.after_cud();
        })
        .fail(function () {
            // An error occurred
          console.log(ummu);
        });
      },

      approve: function () {
        var rows = $hizb.vars.rows;
        var row = $hizb.vars.row;
        var url = globalVar.pageUrl;
        var r = [];

        if ($hizb.vars.is_row == true) {
          r = [row.id];
        } else {
          $.each(rows, function (index, value) {
            r[index] = {};
            r[index] = value.id;
          });
        }

        var payload = JSON.stringify({
          body: {
            ids: r,
          },
        });

        var params = {
          url: url + "approve",
          type: "put",
          // "action": "insert",
          data: payload,
          cache: true,
          contentType: "application/json",
          dataType: "json",
        };

        // console.log(r)

        $("#text_loader").html("Approve in process...");
        var ummu = $hizb.ajax.ummu3(params);
        $("#modal_approve_confirm").modal("hide");
        ummu
        .done(function (result) {
            // var response = JSON.parse(result);
            // console.log(result)
          table.rows(".selected").remove().draw();
          $hizb.views.hazard_report.layout();
            // $hizb.dt.after_cud();
          $("#modal_form").modal("hide");
        })
        .fail(function () {
            // An error occurred
          console.log(ummu);
        });
      },

      reject: function () {
        var rows = $hizb.vars.rows;
        var row = $hizb.vars.row;
        var url = globalVar.pageUrl;

        if ($hizb.vars.is_row == true) {
          body = [
            {
              id: row.id,
              document_number: row.nomor_dokumen,
              phone_number: row.phone_number,
              remark: $("#modal_reject_confirm #remark").val(),
            },
          ];

          var payload = JSON.stringify({
            body: body,
          });
        } else {
          var r = [];
          var dn = [];
          var phone = [];
          var body = [];

          $.each(rows, function (index, value) {
            r[index] = {};
            dn[index] = {};
            phone[index] = {};

            r[index] = value.id;
            dn[index] = value.document_number;
            phone[index] = value.phone_number;

            body[index] = {
              id: value.id,
              document_number: value.document_number,
              phone_number: value.phone_number,
              remark: $("#modal_reject_confirm #remark").val(),
            };
          });

          var payload = JSON.stringify({
            body: body,
          });
        }

        var params = {
          url: $hizb.vars.page_url + "reject",
          type: "put",
          // "action": "insert",
          data: payload,
          cache: true,
          contentType: "application/json",
          dataType: "json",
        };

        // console.log(payload)

        $("#text_loader").html("Reject in process...");
        var ummu = $hizb.ajax.ummu3(params);
        $("#modal_reject_confirm").modal("hide");
        ummu
        .done(function (result) {
            // var response = JSON.parse(result);
            // console.log(result)
          table.rows(".selected").remove().draw();
          $hizb.views.hazard_report.layout();
          $("#modal_form").modal("hide");
            // $hizb.dt.after_cud();
        })
        .fail(function () {
            // An error occurred
          console.log(ummu);
        });
      },

      reject_one: function () {
        var row = $hizb.vars.row;

        var payload = JSON.stringify({
          body: {
            id: row.id,
            document_number: row.document_number,
            phone_number: row.phone_number,
            remark: $("#modal_reject_confirm #remark").val(),
          },
        });

        var params = {
          url: $hizb.vars.page_url + "reject",
          type: "put",
          // "action": "insert",
          data: payload,
          cache: true,
          contentType: "application/json",
          dataType: "json",
        };

        // console.log(payload)

        $("#text_loader").html("Reject in process...");
        var ummu = $hizb.ajax.ummu3(params);
        $("#modal_reject_confirm").modal("hide");
        ummu
        .done(function (result) {
            // var response = JSON.parse(result);
            // console.log(result)
          table.rows(".selected").remove().draw();
          $hizb.views.hazard_report.layout();
            // $hizb.dt.after_cud();
        })
        .fail(function () {
            // An error occurred
          console.log(ummu);
        });
      },

      reject_do: function () {
        var rows = $hizb.vars.rows;
        var url = globalVar.pageUrl;
        var r = [];
        var dn = [];
        var phone = [];
        var body = [];

        $.each(rows, function (index, value) {
          r[index] = {};
          dn[index] = {};
          phone[index] = {};

          r[index] = value.id;
          dn[index] = value.document_number;
          phone[index] = value.phone_number;

          body[index] = {
            id: value.id,
            document_number: value.document_number,
            phone_number: value.phone_number,
            remark: $("#modal_reject_confirm #remark").val(),
          };
        });

        var payload = JSON.stringify({
          // "body": {
          //     "ids": r,
          //     "doc_number": dn,
          //     "phone_number": phone
          // }

          body: body,
        });

        var params = {
          url: $hizb.vars.page_url + "reject",
          type: "put",
          // "action": "insert",
          data: payload,
          cache: true,
          contentType: "application/json",
          dataType: "json",
        };

        // console.log(payload)

        $("#text_loader").html("Reject in process...");
        var ummu = $hizb.ajax.ummu3(params);
        $("#modal_reject_confirm").modal("hide");
        ummu
        .done(function (result) {
            // var response = JSON.parse(result);
            // console.log(result)
          table.rows(".selected").remove().draw();
          $hizb.views.hazard_report.layout();
            // $hizb.dt.after_cud();
        })
        .fail(function () {
            // An error occurred
          console.log(ummu);
        });
      },
    },

    applicant: {
      approve: function () {
        var rows = $hizb.vars.rows;
        var url = globalVar.pageUrl;
        var r = [];
        $.each(rows, function (index, value) {
          r[index] = {};
          r[index] = value.id;
        });

        var payload = JSON.stringify({
          body: {
            ids: r,
          },
        });

        var params = {
          url: $hizb.vars.page_url + "approve",
          type: "put",
          action: "update",
          data: payload,
          cache: true,
          contentType: "application/json",
          dataType: "json",
        };

        // console.log(params)

        $("#text_loader").html("Approve in process...");
        var ummu = $hizb.ajax.ummu3(params);
        $("#modal_approve_confirm").modal("hide");
        ummu
        .done(function (result) {
            // var response = JSON.parse(result);
            // console.log(result)
          table.rows(".selected").remove().draw();
            // $hizb.dt.after_cud();
        })
        .fail(function () {
            // An error occurred
          console.log(ummu);
        });
      },
      reject: function () {
        var rows = $hizb.vars.rows;
        var r = [];
        $.each(rows, function (index, value) {
          r[index] = {};
          r[index] = value.id;
        });

        var payload = JSON.stringify({
          body: {
            ids: r,
          },
        });

        var params = {
          url: $hizb.vars.page_url + "reject",
          type: "put",
          // "action": "insert",
          data: payload,
          cache: true,
          contentType: "application/json",
          dataType: "json",
        };

        // console.log(params)

        $("#text_loader").html("Reject in process...");
        var ummu = $hizb.ajax.ummu3(params);
        $("#modal_reject_confirm").modal("hide");
        ummu
        .done(function (result) {
            // var response = JSON.parse(result);
            // console.log(result)
          table.rows(".selected").remove().draw();
            // $hizb.dt.after_cud();
        })
        .fail(function () {
            // An error occurred
          console.log(ummu);
        });
      },
    },
  },

  func: {
    ch_message: function (message) {
      const text = '<i class="fas fa-info-circle"></i> ' + message + " . . .";
      $("#response_message").html(text).addClass("text-success msg_animation");
    },

    ch_message_modal: function (message) {
      const text = '<i class="fas fa-info-circle"></i> ' + message + " . . .";
      $("#response_message_modal")
      .html(text)
      .addClass("text-success msg_animation");
    },

    ch_message_modal_modal: function (message) {
      const text = '<i class="fas fa-info-circle"></i> ' + message + " . . .";
      $("#response_message_modal_modal")
      .removeClass()
      .html(text)
      .addClass("text-success msg_animation");
    },

    countDate: function (datetime1, datetime2) {
      var inDetik = new Date(datetime2) - new Date(datetime1);
      var inMenit = Math.floor(inDetik / 60000);
      var inJam = Math.floor(inMenit / 60);
      var inHari = Math.floor(inJam / 24);

      var menit = inMenit - inJam * 60;
      var jam = inJam - inHari * 24;

      var response = inHari + " days, " + jam + " hours, " + menit + " minutes";

      // console.log(jam)
      return response;
    },

    countDate2: function (datetime1, datetime2) {
      var inDetik = new Date(datetime2) - new Date(datetime1);
      var inMenit = Math.floor(inDetik / 60000);
      var inJam = Math.floor(inMenit / 60);
      var inHari = Math.floor(inJam / 24);

      var menit = inMenit - inJam * 60;
      var jam = inJam - inHari * 24;

      var response =
      inHari +
      " <span class='text-muted'>days</span>, " +
      jam +
      " <span class='text-muted'>hours</span>, " +
      menit +
      " <span class='text-muted'>minutes</span>";

      // console.log(jam)
      return response;
    },

    countDate3: function (datetime1, datetime2) {
      var inDetik = new Date(datetime2) - new Date(datetime1);
      var inMenit = Math.floor(inDetik / 60000);
      var inJam = Math.floor(inMenit / 60);
      var inHari = Math.floor(inJam / 24);

      var menit = inMenit - inJam * 60;
      var jam = inJam - inHari * 24;

      var response = inHari + " day, " + jam + " hour, " + menit + " minute";

      // console.log(jam)
      return response;
    },

    countDate4: function (datetime1, datetime2) {
      var inDetik = new Date(datetime2) - new Date(datetime1);
      var inMenit = Math.floor(inDetik / 60000);
      var inJam = Math.floor(inMenit / 60);
      var inJamK = inMenit / 60;

      return inJamK.toFixed(2);
    },

    datetime: {
      jmlMenit: function (datetime1, datetime2) {
        var inDetik = new Date(datetime2) - new Date(datetime1);
        var inMenit = Math.floor(inDetik / 60000);

        return inMenit;
      },
      jmlJam: function (datetime1, datetime2) {
        var inDetik = new Date(datetime2) - new Date(datetime1);
        var inMenit = Math.floor(inDetik / 60000);
        var inJam = Math.floor(inMenit / 60);
        var inJamK = inMenit / 60;

        return inJamK.toFixed(2);
      },
      toText: function (datetime1, datetime2) {
        var inDetik = new Date(datetime2) - new Date(datetime1);
        var inMenit = Math.floor(inDetik / 60000);
        var inJam = Math.floor(inMenit / 60);
        var inHari = Math.floor(inJam / 24);

        var menit = inMenit - inJam * 60;
        var jam = inJam - inHari * 24;

        var response = inHari + " day, " + jam + " hour, " + menit + " minute";

        return response;
      },
    },

    countDate4: function (datetime1, datetime2) {
      var inDetik = new Date(datetime2) - new Date(datetime1);
      var inMenit = Math.floor(inDetik / 60000);
      var inJam = Math.floor(inMenit / 60);
      var inJamK = inMenit / 60;

      return inJamK.toFixed(2);
    },

    countMinute: function (datetime1, datetime2) {
      var inDetik = new Date(datetime2) - new Date(datetime1);
      var inMenit = Math.floor(inDetik / 60000);
      // var inJam = Math.floor(inMenit / 60);
      // var inHari = Math.floor(inJam / 24);

      // var menit = inMenit - (inJam * 60);
      // var jam = inJam - (inHari * 24);

      // var response = inHari + " days, " + jam + " hours, " + menit + " minutes";

      // console.log(jam)
      return inMenit;
    },

    getIdSelections: function () {
      return $.map($table.bootstrapTable("getSelections"), function (row) {
        return row.id;
      });
    },

    set_value_to_option: function (rows, element_id, kode) {
      $("#" + element_id).empty();
      $("#" + element_id).append(
        "<option value='' selected disabled>Choose...</option>"
        );
      for (let index in rows) {
        if (kode == 1) {
          var text = rows[index].kode + " - " + rows[index].name;
        } else {
          var text = rows[index].name;
        }
        $("#" + element_id).append(
          "<option value='" + rows[index].id + "'>" + text + "</option>"
          );
      }
    },

    set_value_to_option2: function (rows, element_id, kode) {
      $("#" + element_id).empty();
      $("#" + element_id).append(
        "<option value='' selected disabled>Choose...</option>"
        );
      for (let index in rows) {
        if (kode == 1) {
          var text = rows[index].kode + " | " + rows[index].name;
        } else {
          var text = rows[index].name;
        }
        $("#" + element_id).append(
          "<option value='" + rows[index].id + "'>" + text + "</option>"
          );
      }
    },

    set_value_to_option3: function (params) {
      var rows = params.rows;
      var element_id = params.element_id;
      var kode = params.kode;
      // var data = params.data;

      $("#" + element_id).empty();
      $("#" + element_id).append(
        "<option value='' selected disabled>Choose...</option>"
        );
      for (let index in rows) {
        if (kode == 1) {
          var text = rows[index].kode + " - " + rows[index].name;
        } else {
          var text = rows[index].name;
        }
        $("#" + element_id).append(
          "<option value='" + rows[index].id + "'>" + text + "</option>"
          );
      }
    },

    date_ymd: function (data) {
      if (data == "null" || data == "" || data == null) {
        return "";
      } else {
        var d = new Date(data),
        month = "" + (d.getMonth() + 1),
        day = "" + d.getDate(),
        year = d.getFullYear();

        if (month.length < 2) month = "0" + month;
        if (day.length < 2) day = "0" + day;

        return [year, month, day].join("-");
      }
    },

    img_ratio: function (element_id) {
      var aspectRatio =
      $("#" + element_id + " img").width() /
      $("#" + element_id + " img").height();

      if (aspectRatio > 1) {
        $("#" + element_id).addClass("circular--landscape");
      } else if (aspectRatio < 1) {
        $("#" + element_id).addClass("circular--portrait");
      } else {
        $("#" + element_id).addClass("circular--square");
      }
    },

    header_avatar_ratio: function (element_id) {
      var aspectRatio = $(element_id).width() / $(element_id).height();

      if (aspectRatio > 1) {
        $(element_id).addClass("circular--landscape-35");
      } else if (aspectRatio < 1) {
        $(element_id).addClass("circular--portrait-35");
      } else {
        $(element_id).addClass("circular--square-35");
      }
    },

    location_hash: function () {
      var urlhash = window.location.hash;
      var urlhashc = Cookies.get("urlhash");

      if (urlhash == urlhashc) {
        $(".nav-tabs li .nav-link").removeClass("active");
        $("[data-bs-target='" + urlhash + "']").addClass("active");

        $(".tab-content .tab-pane").removeClass("active").removeClass("show");

        $(".tab-content " + urlhash)
        .addClass("active")
        .addClass("show");
      }
    },

    rm_elinarr: function (array, value) {
      return array.filter(function (letter) {
        return letter !== value;
      });
    },

    removeItem: function (arr, item) {
      return arr.filter((f) => f !== item);
    },

    between: function (x, min, max) {
      var x = parseFloat(x);
      var min = parseFloat(min);
      var max = parseFloat(max);

      return x >= min && x <= max;
    },

    betweenNotMin: function (x, min, max) {
      var x = parseFloat(x);
      var min = parseFloat(min);
      var max = parseFloat(max);

      return x > min && x < max;
    },

    betweenNotMax: function (x, min, max) {
      var x = parseFloat(x);
      var min = parseFloat(min);
      var max = parseFloat(max);

      return x >= min && x < max;
    },

    approval: {
      gsum: function () {
        // $('#page_hide_spinner').show();
        // $('#modal_loader').modal('show');
        var params = {
          type: "get",
          action: "get",
          data: {
            limit: 0,
            offset: 0,
            sort: "kode",
            order: "asc",
            search: "",
          },
          cache: true,
          contentType: "application/json",
          dataType: "json",
        };
        var url = $base_url + "/admin/dashboard/approval_sum";
        var ali = $hizb.ajax.ummay(url, params);
        ali
        .done(function (result) {
          var response = JSON.parse(result);
            // console.log(response)
          $hizb.localStorage.approval.sum.create(response);
          $hizb.localStorage.approval.sum.show();
            // $('#page_hide_spinner').hide();
            // $('#modal_loader').modal('hide');
        })
        .fail(function () {
            // An error occurred
        });
      },
    },

    getUrlParameter: function (sParam) {
      var sPageURL = window.location.search.substring(1);
      var sURLVariables = sPageURL.split("&");
      for (var i = 0; i < sURLVariables.length; i++) {
        var sParameterName = sURLVariables[i].split("=");
        if (sParameterName[0] == sParam) {
          return sParameterName[1];
        }
      }
    },

    remove_element_by_index: function (index) {
      var tVal = $("#index" + index).val();
      $("#index" + index).remove();
      $hizb.vars.arrayqu = $hizb.func.removeItem($hizb.vars.arrayqu, tVal);
    },

    to_array_from_span_element_by_class: function ($class) {
      const arrayqu = [];
      $("." + $class).each(function () {
        arrayqu.push($(this).text());
      });
      return arrayqu;
    },

    mechanic_activity: {
      dateStart: function () {
        $("#date_start").change(function () {
          var date_start = $("#date_start").val();
          var date_end = $("#date_end").val();
          var time_start = $("#time_start").val();
          var time_end = $("#time_end").val();

          /*jika tgl yg dipilih lebih besar dari tgl end, maka kosongkan tgl end*/
          if (date_start > date_end) {
            $("#date_end").val("");
            $("#time_end").val("__:__");
          }

          var minDateEnd = date_start;

          if (date_start == $hizb.vars.date_start) {
            $("#time_start").val("__:__");

            var minTimeStart = $hizb.vars.time_start;
            
            if ($hizb.vars.time_end) {
              var maxTimeStart = $hizb.vars.time_end;
            } else {
              var maxTimeStart = "23:59";
            }

            if (date_start == $hizb.vars.dNow) {
              var minTimeStart = $hizb.vars.time_start;
              var maxTimeStart = $hizb.vars.time_end;
              // var minTimeEnd = '00:00';
              // var maxTimeEnd = '23:59';
              var minDateEnd = date_start;
              if ($hizb.vars.date_end == null) {
                var maxDateEnd = $hizb.vars.dNow;
              } else {
                var maxDateEnd = $hizb.vars.date_end;
              }
            }
          } else {
            if (date_start == $hizb.vars.dNow) {
              var minTimeStart = "00:00";
              var maxTimeStart = $hizb.vars.tNow;
              var minDateEnd = date_start;
              var maxDateEnd = date_start;
            }
          }

          /*Jika tidak ada tgl yg dipilih*/
          if (date_start == null || date_start == "____-__-__" || date_start == "") {
            var minDateEnd = $hizb.vars.date_start;
            if ($hizb.vars.date_end == null) {
              var maxDateEnd = $hizb.vars.dNow;
            } else {
              var maxDateEnd = $hizb.vars.date_end;
            }
          }

          // /**
          //  * jika tgl yg dipilih sama dengan tgl dari SAP, dan jika tgl yg dipilih sama dengan tgl sekarang
          //  * */
          // if (date_start == $hizb.vars.date_start && $hizb.vars.date_start == $hizb.vars.dNow) {
          //     var minTimeStart = $hizb.vars.time_start;
          //     var maxTimeStart = $hizb.vars.time_end;
          //     // var minTimeEnd = '00:00';
          //     // var maxTimeEnd = '23:59';
          //     var minDateEnd = date_start;
          //     if ($hizb.vars.date_end == null) {
          //         var maxDateEnd = $hizb.vars.dNow
          //     }else{
          //         var maxDateEnd = $hizb.vars.date_end
          //     }
          // }
          // /**
          //  * jika tgl yg dipilih tidak sama dengan tgl dari SAP, dan jika tgl yg dipilih sama dengan tgl sekarang
          //  * */
          // if (date_start != $hizb.vars.date_start && date_start == $hizb.vars.dNow) {
          //     var minTimeStart = '00:00';
          //     var maxTimeStart = $hizb.vars.tNow;
          //     // var minTimeEnd = '00:00';
          //     // var maxTimeEnd = $hizb.vars.tNow;
          //     var minDateEnd = date_start;
          //     var maxDateEnd = date_start;
          // }
          /**
           * jika tgl yg dipilih lebih besar dari tgl yg ditentukan oleh SAP, dan jika tgl yg dipilih lebih kecil dari tgl sekarang
           * */

          if (date_start > $hizb.vars.date_start && date_start < $hizb.vars.dNow ) {
            var minTimeStart = "00:00";
            var maxTimeStart = "23:59";
            // var minTimeEnd = '00:00';
            // var maxTimeEnd = '23:59';
            var minDateEnd = date_start;
            if ($hizb.vars.date_end == null) {
              var maxDateEnd = $hizb.vars.dNow;
            } else {
              var maxDateEnd = $hizb.vars.date_end;
            }
          }
        });

        // /*if (date_start == $hizb.vars.dNow) {
        //               if (date_start == $hizb.vars.date_start) {
        //                   var minTimeStart = $hizb.vars.time_start;
        //                   var maxTimeStart = $hizb.vars.time_end;
        //                   // var minTimeEnd = '00:00';
        //                   // var maxTimeEnd = '23:59';
        //                   var minDateEnd = date_start;
        //                   if ($hizb.vars.date_end == null) {
        //                       var maxDateEnd = $hizb.vars.dNow
        //                   }else{
        //                       var maxDateEnd = $hizb.vars.date_end
        //                   }
        //               }else{
        //                   var minTimeStart = '00:00';
        //                   var maxTimeStart = $hizb.vars.tNow;
        //                   // var minTimeEnd = '00:00';
        //                   // var maxTimeEnd = $hizb.vars.tNow;
        //                   var minDateEnd = date_start;
        //                   var maxDateEnd = date_start;
        //               }
        //           }*/
        // /*if (date_start == $hizb.vars.date_start) {
        //               var mintimestart = $hizb.vars.time_start
        //           }else{
        //               var mintimestart = '00:00'
        //           }*/

        // $("#time_start").datetimepicker({
        //   minTime: minTimeStart,
        //   maxTime: maxTimeStart,
        // });
        // $("#date_end").datetimepicker({
        //   minDate: minDateEnd,
        //   maxDate: maxDateEnd,
        // });
      },

      timeStart: function () {
        $("#time_start").change(function () {
          var date_start = $("#date_start").val();
          var date_end = $("#date_end").val();
          var time_start = $("#time_start").val();
          var time_end = $("#time_end").val();

          if (date_start == null || date_start == "____-__-__" || date_start == "") {
            $("#message_modal").modal("show");
            $("#message_title").html("Validations");
            $("#text_message").html('<div class="alert alert-danger" role="alert">isi DateStart terlebih dahulu</div>');
            $(this).val("__:__");
          }
        });
      },

      dateEnd: function () {
      // var date_start = $('#date_start').val();
      // var date_end = $('#date_end').val();

      // if (date_start == date_end) {
      //     var mintimeend = $hizb.vars.time_start
      //     // var maxtimeend = '23:00'
      // }else{
      //     var mintimeend = '00:00'
      // }

      // if (date_end == $hizb.vars.d) {
      //     var maxtimeend = $hizb.vars.t
      // }

      // $('#time_end').datetimepicker({
      //     minTime:mintimeend,
      //     maxTime:maxtimeend
      // });

      // $('#date_end').on('change', function() {
      //     var date_start = $('#date_start').val();
      //     var date_end = $('#date_end').val();

      //     /**
      //      * jika tgl yg dipilih lebih besar dari tgl end, maka kosongkan tgl end
      //      */
      //     if (date_start > date_end) {
      //         $('#date_end').val("");
      //     }
      //     var minDateEnd = date_start;

      //     /**
      //      * Jika tidak tgl yg dipilih
      //      * */
      //     if (date_start == null || date_start == "____-__-__" || date_start == "") {
      //         var minDateEnd = $hizb.vars.date_start;
      //         if ($hizb.vars.date_end == null) {
      //             var maxDateEnd = $hizb.vars.dNow
      //         }else{
      //             var maxDateEnd = $hizb.vars.date_end
      //         }
      //     }

      //     /**
      //      * jika tgl yg dipilih sama dengan tgl dari SAP, dan jika tgl yg dipilih sama dengan tgl sekarang
      //      * */
      //     if (date_start == $hizb.vars.date_start && $hizb.vars.date_start == $hizb.vars.dNow) {

      //         var minTimeStart = $hizb.vars.time_start;
      //         var maxTimeStart = $hizb.vars.time_end;

      //         // var minTimeEnd = '00:00';
      //         // var maxTimeEnd = '23:59';

      //         var minDateEnd = date_start;
      //         if ($hizb.vars.date_end == null) {
      //             var maxDateEnd = $hizb.vars.dNow
      //         }else{
      //             var maxDateEnd = $hizb.vars.date_end
      //         }

      //     }

      //     /**
      //      * jika tgl yg dipilih tidak sama dengan tgl dari SAP, dan jika tgl yg dipilih sama dengan tgl sekarang
      //      * */
      //     if (date_start != $hizb.vars.date_start && date_start == $hizb.vars.dNow) {

      //         var minTimeStart = '00:00';
      //         var maxTimeStart = $hizb.vars.tNow;

      //         // var minTimeEnd = '00:00';
      //         // var maxTimeEnd = $hizb.vars.tNow;

      //         var minDateEnd = date_start;
      //         var maxDateEnd = date_start;

      //     }

      //     /**
      //      * jika tgl yg dipilih lebih besar dari tgl yg ditentukan oleh SAP, dan jika tgl yg dipilih lebih kecil dari tgl sekarang
      //      * */
      //     if (date_start > $hizb.vars.date_start && date_start < $hizb.vars.dNow) {

      //         var minTimeStart = '00:00';
      //         var maxTimeStart = '23:59';

      //         // var minTimeEnd = '00:00';
      //         // var maxTimeEnd = '23:59';

      //         var minDateEnd = date_start;
      //         if ($hizb.vars.date_end == null) {
      //             var maxDateEnd = $hizb.vars.dNow
      //         }else{
      //             var maxDateEnd = $hizb.vars.date_end
      //         }

      //     }

      //     // if (date_start == $hizb.vars.dNow) {

      //     //     if (date_start == $hizb.vars.date_start) {

      //     //         var minTimeStart = $hizb.vars.time_start;
      //     //         var maxTimeStart = $hizb.vars.time_end;

      //     //         // var minTimeEnd = '00:00';
      //     //         // var maxTimeEnd = '23:59';

      //     //         var minDateEnd = date_start;
      //     //         if ($hizb.vars.date_end == null) {
      //     //             var maxDateEnd = $hizb.vars.dNow
      //     //         }else{
      //     //             var maxDateEnd = $hizb.vars.date_end
      //     //         }

      //     //     }else{

      //     //         var minTimeStart = '00:00';
      //     //         var maxTimeStart = $hizb.vars.tNow;

      //     //         // var minTimeEnd = '00:00';
      //     //         // var maxTimeEnd = $hizb.vars.tNow;

      //     //         var minDateEnd = date_start;
      //     //         var maxDateEnd = date_start;

      //     //     }
      //     // }

      //     // if (date_start == $hizb.vars.date_start) {
      //     //     var mintimestart = $hizb.vars.time_start
      //     // }else{
      //     //     var mintimestart = '00:00'
      //     // }

      //     $('#time_start').datetimepicker({
      //         minTime: minTimeStart,
      //         maxTime: maxTimeStart
      //     });

      //     $('#date_end').datetimepicker({
      //         minDate: minDateEnd,
      //         maxDate: maxDateEnd
      //     });
      // });

        $("#date_end").change(function () {
          var date_start = $("#date_start").val();
          var date_end = $("#date_end").val();
          var time_start = $("#time_start").val();
          var time_end = $("#time_end").val();

        // var minTimeStart = $hizb.vars.time_start;
        // if ($hizb.vars.time_end) {
        //     var maxTimeStart = $hizb.vars.time_end;
        // }else{
        //     var maxTimeStart = '23:59';
        // }

          $("#time_end").val("__:__");

          if (time_start == null || time_start == "__:__" || time_start == "") {
            $("#message_modal").modal("show");
            $("#message_title").html("Validations");
            $("#text_message").html(
              '<div class="alert alert-danger" role="alert">' +
              "Isi TimeStart terlebih dahulu" +
              "</div>"
              );
            $(this).val("____-__-__");
          }

        // if (date_end == date_start) {
        //     if (date_end == $hizb.vars.date_start) {
        //         if (date_end == $hizb.vars.dNow) {
        //             $('#time_end').datetimepicker({
        //                 minTime: time_start,
        //                 maxTime: $hizb.vars.tNow
        //             });
        //         }else{
        //             $('#time_end').datetimepicker({
        //                 minTime: time_start,
        //                 maxTime: '23:59'
        //             });
        //         }
        //     }else{
        //         if (date_end == $hizb.vars.dNow) {
        //             $('#time_end').datetimepicker({
        //                 minTime: time_start,
        //                 maxTime: $hizb.vars.tNow
        //             });
        //         }else{
        //             $('#time_end').datetimepicker({
        //                 minTime: time_start,
        //                 maxTime: '23:59'
        //             });
        //         }
        //     }

        //     // if (date_end == $hizb.vars.dNow) {
        //     //     $('#time_end').datetimepicker({
        //     //         minTime: time_start,
        //     //         maxTime: $hizb.vars.tNow
        //     //     });
        //     // }

        //     // if (date_end == ) {
        //     //     $('#time_end').datetimepicker({
        //     //         minTime: time_start,
        //     //         maxTime: '23:59'
        //     //     });
        //     // }

        //     // if (date_end == $hizb.vars.dNow) {
        //     //     $('#time_end').datetimepicker({
        //     //         minTime: time_start,
        //     //         maxTime: $hizb.vars.time_end
        //     //     });
        //     // }
        // }

          if (
            date_end == date_start ||
            date_end == $hizb.vars.date_end ||
            date_end == $hizb.vars.dNow
            ) {
            var min_time = time_start;
        } else {
          var min_time = $hizb.vars.min_time;
        }

        if (date_end == $hizb.vars.dNow || date_end == $hizb.vars.date_end) {
          var max_time = $hizb.vars.tNow;
        } else {
          if ($hizb.vars.time_end) {
            var max_time = $hizb.vars.time_end;
          } else {
            var max_time = "23:59";
          }
        }

        // if (date_end == $hizb.vars.dNow) {
        //     var max_time = $hizb.vars.tNow;
        // }

        $("#time_end").datetimepicker({
          minTime: min_time,
          maxTime: max_time,
        });
      });
      },

      timeEnd: function () {
        $("#time_end").change(function () {
          var date_start = $("#date_start").val();
          var date_end = $("#date_end").val();
          var time_start = $("#time_start").val();
          var time_end = $("#time_end").val();
        // $('#time_end').change(function(){
        //     // $('#time_start').datetimepicker({
        //     //     minTime: minTimeStart,
        //     //     maxTime: maxTimeStart
        //     // });
        //     if (date_end == null || date_end == "____-__-__" || date_end == "") {
        //         $('#message_modal').modal('show');
        //         $('#message_title').html("Validations");
        //         $('#text_message').html('<div class="alert alert-danger" role="alert">'+
        //                                     'isi DateEnd terlebih dahulu'+
        //                                 '</div>');
        //         $(this).val("__:__");
        //     }
        // })
          var workstart = date_start + " " + time_start;
          var workend = date_end + " " + time_end;

          var datetime1 = date_start + " " + time_start;
          var datetime2 = date_end + " " + time_end;

          var jmlMenit = $hizb.func.datetime.jmlMenit(datetime1, datetime2);
          var jmlJam = $hizb.func.datetime.jmlJam(datetime1, datetime2);
          var toText = $hizb.func.datetime.toText(datetime1, datetime2);

          $("#duration").val(jmlMenit);
          $("#duration2").val(jmlJam.replace(".", ","));
          $("#duration_text").val(toText);

        // console.log(countdate)
        // console.log(workstart)
        // console.log(workend)
        });
      // console.log("OK")
      },
    },
  },

  upload: {
    filename: null,
    randomname: null,
    input_id: null,
    image_id: null,
    ids: [],
    filenames: [],

    /*findAll_berangkas: function() {
    // $.ajax({
    //     type: 'GET',
    //     url: $base_url + "admin/berangkas/findAll",
    //     dataType: 'JSON',
    //     contentType: false,
    //     processData: false,
    // }).done(function(result) {
    //     console.log(result.status)
    //     if (result.status == true) {
    //         var data = result.rows;
    //         $('#album_berangkas').empty();
    //         for(let index in data){
    //             var $id = data[index].id;
    //             var filename = data[index].filename;
    //             if(filename == ''){
    //                 var $filename = 'no_image.jpg';
    //             }else{
    //                 var $filename = filename;
    //             }
    //             var $element = '<div class="col">'+
    //                 '<div class="card shadow-sm">'+
    //                     '<img class="img-thumbnail" src="'+ $base_url +'uploads/'+ $filename + '" style="height:160px;">'+
    //                     '<div class="card-body">'+
    //                         '<div class="d-flex justify-content-between align-items-center pt-3">'+
    //                             '<button type="button" class="btn btn-sm btn-outline-danger" onclick="$hizb.upload.hapus_file_berangkas('+$id+')">Hapus</button>'+
    //                             '<button type="button" class="btn btn-sm btn-outline-success pilih-berkas" data-name="'+$filename+'">Pilih</button>'+
    //                         '</div>'+
    //                     '</div>'+
    //                 '</div>'+
    //             '</div>';
    //             $('#album_berangkas').append($element);
    //         }
    //         $('.pilih-berkas').click(function(){
    //             var $data_name = $(this).data('name');
    //             $hizb.upload.input_id.val($data_name)
    //             $('#modal_berangkas_file').modal('hide')
    //             $hizb.upload.image_id.attr('src', $base_url + 'uploads/' + $data_name)
    //         })
    //     }else{

    //     }
    // }).fail(function() {
    //     // An error occurred
    // });;

    var params = {
    "type": "get",
    "action": "get",
    "data": {
    "limit":0,
    "offset":0,
    "sort": "id",
    "order": "desc",
    "search": ""
    },
    "cache": true,
    "contentType": "application/json",
    "dataType": "json"
    };
    var url = $base_url+'/admin/berangkas/show';
    var ali = $globalAjax.ummay(url,params);
    ali.done(function(result) {
    var response = JSON.parse(result);
    $globFunc.ch_message_modal_modal(response.message);
    // console.log(response.message)
    // var params2 = {
    //     "rows": response.rows,
    //     "element_id": 'gedung',
    //     "kode": 1
    // };

    // // $globFunc.set_value_to_option(response.rows,'gedung',1)
    // // $globFunc.set_value_to_option3(params2)
    // app.Views.set_value_to_option_gedung(params2)

    var data = response.rows;
    $('#album_berangkas').empty();
    for(let index in data){
    var $id = data[index].id;
    var id = data[index].id;
    var filename = data[index].filename;
    var description = data[index].description;

    if(filename == ''){
    var $filename = 'no_image.jpg';
    }else{
    var $filename = filename;
    }

    if (description == '' || description == null) {
    var description_ = filename;
    }else{
    var description_ = description;
    }

    // var $elementz = '<div class="col">'+
    //     '<div class="card shadow-sm">'+
    //         '<img class="img-thumbnail" src="'+ $base_url +'uploads/'+ $filename + '" style="height:160px;">'+
    //         '<div class="card-body">'+
    //             '<div class="d-flex justify-content-between align-items-center pt-3">'+
    //                 '<button type="button" class="btn btn-sm btn-outline-danger" onclick="$hizb.upload.hapus_file_berangkas('+$id+')"><i class="fas fa-trash"></i></button>'+
    //                 '<button type="button" class="btn btn-sm btn-outline-success pilih-berkas" data-name="'+$filename+'">Pilih</button>'+
    //                 '<input class="form-check-input dorbitt-checkbox" type="checkbox">'+
    //             '</div>'+
    //         '</div>'+
    //     '</div>'+
    // '</div>';

    var $element = '<div class="cont-checkbox">'+
    '<input type="checkbox" class="dorbitt_checkbox_image_berangkas" name="dorbitt_checkbox_image_berangkas" id="'+id+'" data-name="'+$filename+'" />'+
    '<label for="'+id+'" class="lbl_berangkas">'+
    '<img src="'+ $base_url +'uploads/'+ $filename + '?crop=0.781xw:0.739xh;0.109xw,0.0968xh&resize=480:*"/>'+
    '<span class="cover-checkbox">'+
    '<svg viewBox="0 0 12 10">'+
    '<polyline points="1.5 6 4.5 9 10.5 1"></polyline>'+
    '</svg>'+
    '</span>'+
    '<div class="info">'+description_+'</div>'+
    '</label>'+
    '</div>';
    $('#album_berangkas').append($element);
    }
    $('.pilih-berkas').click(function(){
    var $data_name = $(this).data('name');
    $hizb.upload.input_id.val($data_name)
    $('#modal_berangkas_file').modal('hide')
    $hizb.upload.image_id.attr('src', $base_url + 'uploads/' + $data_name)
    })
    }).fail(function() {
    // An error occurred
    });
    },*/

    button: function () {
      $("#dorbitt_open_gallery").click(function () {
        var dataImage = $(this).attr("data-image");
        $hizb.upload.show_gallery();
        $("#modal_gallery").modal("show");
        // $hizb.upload.input_id = input_id;
        // $hizb.upload.image_id = image_id;
      });

      $("#dorbitt_open_gallery2").click(function () {
        var dataImage = $(this).attr("data-image");
        $hizb.upload.show_gallery2();
        $("#modal_gallery").modal("show");
        // $hizb.upload.input_id = input_id;
        // $hizb.upload.image_id = image_id;
      });

      $("#btn_select_file").click(function () {
        var ids = [];
        var filenames = [];
        $(".dorbitt_checkbox_image_gallery:checked").each(function () {
          var id = $(this).attr("id");
          var filename = $(this).data("name");

          ids.push(parseInt(id));
          filenames.push(filename);
          // console.log(filename)
        });

        $hizb.upload.ids = ids;
        $hizb.upload.filenames = filenames;

        /*buat function dan custom sendiri di project masing-masing*/
        app.Views.set_gallery_selected_to_img(filenames);

        $("#modal_gallery").modal("hide");
        // console.log(ids)
      });
    },

    show_gallery: function () {
      if ($globalVar.page == "gallery") {
        var page = "gallery/show";
      } else {
        var page = $globalVar.page + "/show_gallery";
      }
      var params = {
        type: "get",
        action: "get",
        data: {
          limit: 0,
          offset: 0,
          sort: "id",
          order: "desc",
          search: "",
          created_by: true,
        },
        cache: true,
        contentType: "application/json",
        dataType: "json",
      };
      var url = $base_url + "/admin/" + page;
      var ali = $globalAjax.ummay(url, params);
      ali
      .done(function (result) {
        var response = JSON.parse(result);
        $globFunc.ch_message_modal_modal(response.message);
        var data = response.rows;
        $("#album_gallery").empty();
        for (let index in data) {
          var $id = data[index].id;
          var id = data[index].id;
          var filename = data[index].filename;
          var description = data[index].description;

          if (filename == "") {
            var $filename = "no_image.jpg";
          } else {
            var $filename = filename;
          }

          if (description == "" || description == null) {
            var description_ = filename;
          } else {
            var description_ = description;
          }

          var $element =
          '<div class="cont-checkbox">' +
          '<input type="checkbox" class="dorbitt_checkbox_image_gallery" name="dorbitt_checkbox_image_gallery" id="' +
          id +
          '" data-name="' +
          $filename +
          '" />' +
          '<label for="' +
          id +
          '" class="lbl_gallery">' +
          '<img src="' +
          $base_url +
          "uploads/" +
          $filename +
          '?crop=0.781xw:0.739xh;0.109xw,0.0968xh&resize=480:*"/>' +
          '<span class="cover-checkbox">' +
          '<svg viewBox="0 0 12 10">' +
          '<polyline points="1.5 6 4.5 9 10.5 1"></polyline>' +
          "</svg>" +
          "</span>" +
          '<div class="info">' +
          description_ +
          "</div>" +
          "</label>" +
          "</div>";
          $("#album_gallery").append($element);
        }
        $(".pilih-berkas").click(function () {
          var $data_name = $(this).data("name");
          $hizb.upload.input_id.val($data_name);
          $("#modal_gallery").modal("hide");
          $hizb.upload.image_id.attr(
            "src",
            $base_url + "uploads/" + $data_name
            );
        });
      })
      .fail(function () {
          // An error occurred
      });
    },

    show_gallery2: function () {
      var page = "gallery/show";
      var params = {
        type: "get",
        action: "get",
        data: {
          limit: 0,
          offset: 0,
          sort: "id",
          order: "desc",
          search: "",
          created_by: true,
        },
        cache: true,
        contentType: "application/json",
        dataType: "json",
      };
      var url = $base_url + "/admin/" + page;
      var ali = $globalAjax.ummay(url, params);
      ali
      .done(function (result) {
        var response = JSON.parse(result);
        $globFunc.ch_message_modal_modal(response.message);
        var data = response.rows;
        $("#album_gallery").empty();
        for (let index in data) {
          var $id = data[index].id;
          var id = data[index].id;
          var filename = data[index].filename;
          var description = data[index].description;

          if (filename == "") {
            var $filename = "no_image.jpg";
          } else {
            var $filename = filename;
          }

          if (description == "" || description == null) {
            var description_ = filename;
          } else {
            var description_ = description;
          }

          var $element =
          '<div class="cont-checkbox">' +
          '<input type="checkbox" class="dorbitt_checkbox_image_gallery" name="dorbitt_checkbox_image_gallery" id="' +
          id +
          '" data-name="' +
          $filename +
          '" />' +
          '<label for="' +
          id +
          '" class="lbl_gallery">' +
          '<img src="' +
          $base_url +
          "uploads/" +
          $filename +
          '?crop=0.781xw:0.739xh;0.109xw,0.0968xh&resize=480:*"/>' +
          '<span class="cover-checkbox">' +
          '<svg viewBox="0 0 12 10">' +
          '<polyline points="1.5 6 4.5 9 10.5 1"></polyline>' +
          "</svg>" +
          "</span>" +
          '<div class="info">' +
          description_ +
          "</div>" +
          "</label>" +
          "</div>";
          $("#album_gallery").append($element);
        }
        $(".pilih-berkas").click(function () {
          var $data_name = $(this).data("name");
          $hizb.upload.input_id.val($data_name);
          $("#modal_gallery").modal("hide");
          $hizb.upload.image_id.attr(
            "src",
            $base_url + "uploads/" + $data_name
            );
        });
      })
      .fail(function () {
          // An error occurred
      });
    },

    upload_file_gallery: function () {
      var formData = new FormData();
      formData.append("file_upload", $("#file_upload")[0].files[0]);
      $.ajax({
        url: $base_url + "admin/gallery/do_upload",
        method: "POST",
        timeout: 0,
        processData: false,
        mimeType: "multipart/form-data",
        contentType: false,
        data: formData,
        beforeSend: function (e) {
          $("#modal_loader_submit_file").show();
          if (e && e.overrideMimeType) {
            e.overrideMimeType("application/jsoncharset=UTF-8");
          }
        },
        complete: function () {
          $("#modal_loader_submit_file").hide();
        },
      })
      .done(function (result) {
        var response = JSON.parse(result);
          // console.log(response)
          // console.log(response.status)
        if (response.status == true) {
            // $hizb.upload.randomname = response.name;
          var payload = JSON.stringify({
            body: {
              filename: response.name,
              description: $("#file_description").val(),
            },
          });
          $hizb.upload.insert_file_gallery(payload);
        } else {
          $("#modal_alert_submit_file").addClass("bg-success");
          $("#modal_alert_submit_file")
          .html(response.errors.file_upload)
          .fadeIn()
          .delay(10000)
          .fadeOut();
        }
      })
      .fail(function () {
          // An error occurred
      });
    },

    insert_file_gallery: function (payload) {
      $.ajax({
        url: $base_url + "admin/gallery/create",
        method: "POST",
        timeout: 0,
        processData: false,
        mimeType: "multipart/form-data",
        contentType: false,
        data: payload,
        beforeSend: function (e) {
          $("#modal_loader_submit_file").show();
          if (e && e.overrideMimeType) {
            e.overrideMimeType("application/jsoncharset=UTF-8");
          }
        },
        complete: function () {
          $("#modal_loader_submit_file").hide();
        },
        error: function (xhr, ajaxOptions, thrownError) {
          alert(xhr.responseText);
        },
      })
      .done(function (result) {
          // console.log(result)
        var response = JSON.parse(result);
        if (response.status == true) {
          $("#modal_alert_submit_file").addClass("bg-success");
          $("#modal_alert_submit_file")
          .html("Upload sukses")
          .fadeIn()
          .delay(10000)
          .fadeOut();
          $hizb.upload.show_gallery();
          $("#upload_img_thumbnail").attr(
            "src",
            $base_url + "uploads/no_image.jpg"
            );
          $("#file_upload, #file_description").val("");
        } else {
            // $('#message_alert').html("");
            // var errors = response.message;
            // for(let index in errors){
            //     $('#message_alert').append("<li>"+errors[index]+"</li>");
            // }
            // $('#message_modal').modal('show');
        }
        $globFunc.ch_message_modal_modal(response.message);
      })
      .fail(function () {
          // An error occurred
        console.log(create);
      });
    },

    hapus_file_gallery: function (id) {
      $.ajax({
        url: $base_url + "admin/gallery/delete/" + id,
        method: "DELETE",
        timeout: 0,
        beforeSend: function (e) {
          $("#modal_loader_gallery").show();
          if (e && e.overrideMimeType) {
            e.overrideMimeType("application/jsoncharset=UTF-8");
          }
        },
        complete: function () {
          $("#modal_loader_gallery").hide();
        },
        success: function (response) {
          // console.log(response)
        },
        error: function (xhr, ajaxOptions, thrownError) {
          alert(xhr.responseText);
        },
      })
      .done(function (result) {
        var response = JSON.parse(result);
        console.log(response.status);
        if (response.status == true) {
          $hizb.upload.show_gallery();
        }
      })
      .fail(function () {
          // An error occurred
      });
    },

    file: function () {
      var formData = new FormData();
      formData.append("file_upload", $("#file_upload")[0].files[0]);
      formData.append("file_description", $("#file_description").val());
      return $.ajax({
        url: $base_url + "mygallery/photos/create",
        method: "POST",
        timeout: 0,
        processData: false,
        mimeType: "multipart/form-data",
        contentType: false,
        data: formData,
        beforeSend: function (e) {
          $("#modal_loader").modal("show");
          if (e && e.overrideMimeType) {
            e.overrideMimeType("application/jsoncharset=UTF-8");
          }
        },
        complete: function () {
          setTimeout(function () {
            $(".modal-loader").modal("hide");
          }, 1000);
        },
        error: function (xhr, ajaxOptions, thrownError) {
          alert(xhr.responseText);
        },
      });
      // return formData;
    },
  },

  gallery: {
    filename: null,
    randomname: null,
    input_id: null,
    image_id: null,
    ids: [],
    filenames: [],

    button: function () {
      $("#dorbitt_open_gallery").click(function () {
        $("#modal_loader_gallery").show();
        var dataImage = $(this).attr("data-image");
        $hizb.gallery.show();
        $("#modal_gallery").modal("show");
        // $hizb.gallery.input_id = input_id;
        // $hizb.gallery.image_id = image_id;
      });

      $("#dorbitt_open_gallery2").click(function () {
        $("#modal_loader_gallery").show();
        var dataImage = $(this).attr("data-image");
        $hizb.gallery.show2();
        $("#modal_gallery").modal("show");
        // $hizb.gallery.input_id = input_id;
        // $hizb.gallery.image_id = image_id;
      });

      $("#btn_select_file").click(function () {
        var ids = [];
        var filenames = [];
        $(".dorbitt_checkbox_image_gallery:checked").each(function () {
          var id = $(this).attr("id");
          var filename = $(this).data("name");

          ids.push(parseInt(id));
          filenames.push(filename);
          // console.log(filename)
        });

        $hizb.gallery.ids = ids;
        $hizb.gallery.filenames = filenames;

        /*buat function dan custom sendiri di project masing-masing*/
        app.Views.set_gallery_selected_to_img(filenames);

        $("#modal_gallery").modal("hide");
        // console.log(ids)
      });
    },

    show: function () {
      if ($globalVar.page == "gallery") {
        var page = "gallery/show";
      } else {
        var page = $globalVar.page + "/show_gallery";
      }
      var params = {
        type: "get",
        action: "get",
        data: {
          limit: 0,
          offset: 0,
          sort: "id",
          order: "desc",
          search: "",
          created_by: true,
        },
        cache: true,
        contentType: "application/json",
        dataType: "json",
      };
      var url = $base_url + "/admin/" + page;
      var ali = $globalAjax.ummay(url, params);
      ali
      .done(function (result) {
        var response = JSON.parse(result);
        $globFunc.ch_message_modal_modal(response.message);
        var data = response.rows;
        $("#album_gallery").empty();
        for (let index in data) {
          var $id = data[index].id;
          var id = data[index].id;
          var filename = data[index].filename;
          var description = data[index].description;

          if (filename == "") {
            var $filename = "no_image.jpg";
          } else {
            var $filename = filename;
          }

          if (description == "" || description == null) {
            var description_ = filename;
          } else {
            var description_ = description;
          }

          var $element =
          '<div class="cont-checkbox">' +
          '<input type="checkbox" class="dorbitt_checkbox_image_gallery" name="dorbitt_checkbox_image_gallery" id="' +
          id +
          '" data-name="' +
          $filename +
          '" />' +
          '<label for="' +
          id +
          '" class="lbl_gallery">' +
          '<img src="' +
          $base_url +
          "uploads/" +
          $filename +
          '?crop=0.781xw:0.739xh;0.109xw,0.0968xh&resize=480:*"/>' +
          '<span class="cover-checkbox">' +
          '<svg viewBox="0 0 12 10">' +
          '<polyline points="1.5 6 4.5 9 10.5 1"></polyline>' +
          "</svg>" +
          "</span>" +
          '<div class="info">' +
          description_ +
          "</div>" +
          "</label>" +
          "</div>";
          $("#album_gallery").append($element);
        }
        $(".pilih-berkas").click(function () {
          var $data_name = $(this).data("name");
          $hizb.gallery.input_id.val($data_name);
          $("#modal_gallery").modal("hide");
          $hizb.gallery.image_id.attr(
            "src",
            $base_url + "uploads/" + $data_name
            );
        });
        $("#modal_loader_gallery").hide();
      })
      .fail(function () {
          // An error occurred
      });
    },

    show2: function () {
      var page = "gallery/show";
      var params = {
        type: "get",
        action: "get",
        data: {
          limit: 0,
          offset: 0,
          sort: "id",
          order: "desc",
          search: "",
          created_by: true,
        },
        cache: true,
        contentType: "application/json",
        dataType: "json",
      };
      var url = $base_url + "/admin/" + page;
      var ali = $globalAjax.ummay(url, params);
      ali
      .done(function (result) {
        var response = JSON.parse(result);
        $globFunc.ch_message_modal_modal(response.message);
        var data = response.rows;
        $("#album_gallery").empty();
        for (let index in data) {
          var $id = data[index].id;
          var id = data[index].id;
          var filename = data[index].filename;
          var description = data[index].description;

          if (filename == "") {
            var $filename = "no_image.jpg";
          } else {
            var $filename = filename;
          }

          if (description == "" || description == null) {
            var description_ = filename;
          } else {
            var description_ = description;
          }

          var $element =
          '<div class="cont-checkbox">' +
          '<input type="checkbox" class="dorbitt_checkbox_image_gallery" name="dorbitt_checkbox_image_gallery" id="' +
          id +
          '" data-name="' +
          $filename +
          '" />' +
          '<label for="' +
          id +
          '" class="lbl_gallery">' +
          '<img src="' +
          $base_url +
          "uploads/" +
          $filename +
          '?crop=0.781xw:0.739xh;0.109xw,0.0968xh&resize=480:*"/>' +
          '<span class="cover-checkbox">' +
          '<svg viewBox="0 0 12 10">' +
          '<polyline points="1.5 6 4.5 9 10.5 1"></polyline>' +
          "</svg>" +
          "</span>" +
          '<div class="info">' +
          description_ +
          "</div>" +
          "</label>" +
          "</div>";
          $("#album_gallery").append($element);
          $("#modal_loader_gallery").hide();
        }
        $(".pilih-berkas").click(function () {
          var $data_name = $(this).data("name");
          $hizb.gallery.input_id.val($data_name);
          $("#modal_gallery").modal("hide");
          $hizb.gallery.image_id.attr(
            "src",
            $base_url + "uploads/" + $data_name
            );
        });
      })
      .fail(function () {
          // An error occurred
      });
    },

    gallery_file_gallery: function () {
      var formData = new FormData();
      formData.append("file_gallery", $("#file_gallery")[0].files[0]);
      $.ajax({
        url: $base_url + "admin/gallery/do_gallery",
        method: "POST",
        timeout: 0,
        processData: false,
        mimeType: "multipart/form-data",
        contentType: false,
        data: formData,
        beforeSend: function (e) {
          $("#modal_loader_submit_file").show();
          if (e && e.overrideMimeType) {
            e.overrideMimeType("application/jsoncharset=UTF-8");
          }
        },
        complete: function () {
          $("#modal_loader_submit_file").hide();
        },
      })
      .done(function (result) {
        var response = JSON.parse(result);
          // console.log(response)
          // console.log(response.status)
        if (response.status == true) {
            // $hizb.gallery.randomname = response.name;
          var payload = JSON.stringify({
            body: {
              filename: response.name,
              description: $("#file_description").val(),
            },
          });
          $hizb.gallery.insert_file_gallery(payload);
        } else {
          $("#modal_alert_submit_file").addClass("bg-success");
          $("#modal_alert_submit_file")
          .html(response.errors.file_gallery)
          .fadeIn()
          .delay(10000)
          .fadeOut();
        }
      })
      .fail(function () {
          // An error occurred
      });
    },

    insert_file_gallery: function (payload) {
      $.ajax({
        url: $base_url + "admin/gallery/create",
        method: "POST",
        timeout: 0,
        processData: false,
        mimeType: "multipart/form-data",
        contentType: false,
        data: payload,
        beforeSend: function (e) {
          $("#modal_loader_submit_file").show();
          if (e && e.overrideMimeType) {
            e.overrideMimeType("application/jsoncharset=UTF-8");
          }
        },
        complete: function () {
          $("#modal_loader_submit_file").hide();
        },
        error: function (xhr, ajaxOptions, thrownError) {
          alert(xhr.responseText);
        },
      })
      .done(function (result) {
          // console.log(result)
        var response = JSON.parse(result);
        if (response.status == true) {
          $("#modal_alert_submit_file").addClass("bg-success");
          $("#modal_alert_submit_file")
          .html("gallery sukses")
          .fadeIn()
          .delay(10000)
          .fadeOut();
          $hizb.gallery.show();
          $("#gallery_img_thumbnail").attr(
            "src",
            $base_url + "gallerys/no_image.jpg"
            );
          $("#file_gallery, #file_description").val("");
        } else {
            // $('#message_alert').html("");
            // var errors = response.message;
            // for(let index in errors){
            //     $('#message_alert').append("<li>"+errors[index]+"</li>");
            // }
            // $('#message_modal').modal('show');
        }
        $globFunc.ch_message_modal_modal(response.message);
      })
      .fail(function () {
          // An error occurred
        console.log(create);
      });
    },

    hapus_file_gallery: function (id) {
      $.ajax({
        url: $base_url + "admin/gallery/delete/" + id,
        method: "DELETE",
        timeout: 0,
        beforeSend: function (e) {
          $("#modal_loader_gallery").show();
          if (e && e.overrideMimeType) {
            e.overrideMimeType("application/jsoncharset=UTF-8");
          }
        },
        complete: function () {
          $("#modal_loader_gallery").hide();
        },
        success: function (response) {
          // console.log(response)
        },
        error: function (xhr, ajaxOptions, thrownError) {
          alert(xhr.responseText);
        },
      })
      .done(function (result) {
        var response = JSON.parse(result);
        console.log(response.status);
        if (response.status == true) {
          $hizb.gallery.show();
        }
      })
      .fail(function () {
          // An error occurred
      });
    },
  },

  mygallery: {
    filename: null,
    randomname: null,
    input_id: null,
    image_id: null,
    ids: [],
    filenames: [],
    paths: [],
    element_inputid: null,
    element_imageid: null,
    show_mygallery: null,

    autoload: function () {
      $(".btn-show-mygallery").on("click", function () {
        var dataImage = $(this).attr("data-image");
        var dataInputID = $(this).attr("data-inputid");
        var dataImageID = $(this).attr("data-imageid");
        $hizb.mygallery.element_inputid = dataInputID;
        $hizb.mygallery.element_imageid = dataImageID;
        $hizb.mygallery.photos.show_for_modal();
        $("#modal_loader_gallery").show();
        $("#modal_mygallery").modal("show");
      });

      $(".img-show-mygallery").on("click", function () {
        if ($hizb.mygallery.show_mygallery == true) {
          var dataImage = $(this).attr("data-image");
          var dataInputID = $(this).attr("data-inputid");
          var dataImageID = $(this).attr("data-imageid");
          $hizb.mygallery.element_inputid = dataInputID;
          $hizb.mygallery.element_imageid = dataImageID;
          $hizb.mygallery.photos.show_for_modal();
          $("#modal_loader_gallery").show();
          $("#modal_mygallery").modal("show");
        }
      });

      $(".dorbitt_checkbox_image_gallery").on("click", function() {
        var id = $(this).attr("id");
        var filename = $(this).data("name");
        var path = $(this).data("path");

        alert('ok')
      });

      $("#mygallery_btn_select_file").on("click", function () {
        var ids = [];
        var filenames = [];
        var paths = [];
        $(".dorbitt_checkbox_image_gallery:checked").each(function () {
          var id = $(this).attr("id");
          var filename = $(this).data("name");
          var path = $(this).data("path");

          ids.push(parseInt(id));
          filenames.push(filename);
          paths.push(path);
        });

        if (ids.length > 0) {
          $hizb.mygallery.ids = ids;
          $hizb.mygallery.filenames = filenames;
          $hizb.mygallery.paths = paths;

          $("#" + $hizb.mygallery.element_inputid).val(filenames);
          $("#" + $hizb.mygallery.element_inputid).attr("data-id", ids);
          $("#" + $hizb.mygallery.element_imageid).attr("src", paths);          
          $("#modal_mygallery").modal("hide");
        }else{
          alert('Please select one or more.');
        }
        // console.log(ids.length)
      });
    },

    show: function () {
      // if ($globalVar.page == 'gallery') {
      //     var page = 'gallery/show';
      // }else{
      //     var page = $globalVar.page+'/show_gallery';
      // }
      var params = {
        type: "get",
        action: "get",
        data: {
          limit: 0,
          offset: 0,
          sort: "id",
          order: "desc",
          search: "",
          created_by: true,
        },
        cache: true,
        contentType: "application/json",
        dataType: "json",
      };
      var url = $base_url + "/mygallery/show";
      var ali = $globalAjax.ummay(url, params);
      ali
      .done(function (result) {
        var response = JSON.parse(result);
        $globFunc.ch_message_modal_modal(response.message);
        var data = response.rows;
        $("#album_gallery").empty();
        for (let index in data) {
          var $id = data[index].id;
          var id = data[index].id;
          var filename = data[index].filename;
          var description = data[index].description;
          var path = data[index].path;
          var file_url = data[index].file_url;

          if (filename == "") {
            var $filename = "no_image.jpg";
          } else {
            var $filename = filename;
          }

          if (description == "" || description == null) {
            var description_ = filename;
          } else {
            var description_ = description;
          }

          var $element =
          '<div class="cont-checkbox mr-2z">' +
          '<input type="checkbox" class="dorbitt_checkbox_image_gallery" name="dorbitt_checkbox_image_gallery" id="' +
          id +
          '" data-name="' +
          filename +
          '" data-path="' +
          file_url +
          '" />' +
          '<label for="' +
          id +
          '" class="lbl_gallery">' +
          '<img src="' +
          file_url +
          '?crop=0.781xw:0.739xh;0.109xw,0.0968xh&resize=480:*"/>' +
          '<span class="cover-checkbox">' +
          '<svg viewBox="0 0 12 10">' +
          '<polyline points="1.5 6 4.5 9 10.5 1"></polyline>' +
          "</svg>" +
          "</span>" +
          '<div class="info">' +
          description_ +
          "</div>" +
          "</label>" +
          "</div>";
          $("#album_gallery").append($element);
        }
          // $('.pilih-berkas').click(function(){
          //     var $data_name = $(this).data('name');
          //     $hizb.mygallery.input_id.val($data_name)
          //     $('#modal_gallery').modal('hide')
          //     $hizb.mygallery.image_id.attr('src', path2)
          // })
        $("#modal_loader_gallery").hide();
      })
      .fail(function () {
          // An error occurred
      });
    },

    show2: function () {
      var page = "gallery/show";
      var params = {
        type: "get",
        action: "get",
        data: {
          limit: 0,
          offset: 0,
          sort: "id",
          order: "desc",
          search: "",
          created_by: true,
        },
        cache: true,
        contentType: "application/json",
        dataType: "json",
      };
      var url = $base_url + "/admin/" + page;
      var ali = $globalAjax.ummay(url, params);
      ali
      .done(function (result) {
        var response = JSON.parse(result);
        $globFunc.ch_message_modal_modal(response.message);
        var data = response.rows;
        $("#album_gallery").empty();
        for (let index in data) {
          var $id = data[index].id;
          var id = data[index].id;
          var filename = data[index].filename;
          var description = data[index].description;

          if (filename == "") {
            var $filename = "no_image.jpg";
          } else {
            var $filename = filename;
          }

          if (description == "" || description == null) {
            var description_ = filename;
          } else {
            var description_ = description;
          }

          var $element =
          '<div class="cont-checkbox">' +
          '<input type="checkbox" class="dorbitt_checkbox_image_gallery" name="dorbitt_checkbox_image_gallery" id="' +
          id +
          '" data-name="' +
          $filename +
          '" />' +
          '<label for="' +
          id +
          '" class="lbl_gallery">' +
          '<img src="' +
          $base_url +
          "uploads/" +
          $filename +
          '?crop=0.781xw:0.739xh;0.109xw,0.0968xh&resize=480:*"/>' +
          '<span class="cover-checkbox">' +
          '<svg viewBox="0 0 12 10">' +
          '<polyline points="1.5 6 4.5 9 10.5 1"></polyline>' +
          "</svg>" +
          "</span>" +
          '<div class="info">' +
          description_ +
          "</div>" +
          "</label>" +
          "</div>";
          $("#album_gallery").append($element);
          $("#modal_loader_gallery").hide();
        }
        $(".pilih-berkas").click(function () {
          var $data_name = $(this).data("name");
          $hizb.gallery.input_id.val($data_name);
          $("#modal_gallery").modal("hide");
          $hizb.gallery.image_id.attr(
            "src",
            $base_url + "uploads/" + $data_name
            );
        });
      })
      .fail(function () {
          // An error occurred
      });
    },

    gallery_file_gallery: function () {
      var formData = new FormData();
      formData.append("file_gallery", $("#file_gallery")[0].files[0]);
      $.ajax({
        url: $base_url + "admin/gallery/do_gallery",
        method: "POST",
        timeout: 0,
        processData: false,
        mimeType: "multipart/form-data",
        contentType: false,
        data: formData,
        beforeSend: function (e) {
          $("#modal_loader_submit_file").show();
          if (e && e.overrideMimeType) {
            e.overrideMimeType("application/jsoncharset=UTF-8");
          }
        },
        complete: function () {
          $("#modal_loader_submit_file").hide();
        },
      })
      .done(function (result) {
        var response = JSON.parse(result);
          // console.log(response)
          // console.log(response.status)
        if (response.status == true) {
            // $hizb.gallery.randomname = response.name;
          var payload = JSON.stringify({
            body: {
              filename: response.name,
              description: $("#file_description").val(),
            },
          });
          $hizb.gallery.insert_file_gallery(payload);
        } else {
          $("#modal_alert_submit_file").addClass("bg-success");
          $("#modal_alert_submit_file")
          .html(response.errors.file_gallery)
          .fadeIn()
          .delay(10000)
          .fadeOut();
        }
      })
      .fail(function () {
          // An error occurred
      });
    },

    insert_file_gallery: function (payload) {
      $.ajax({
        url: $base_url + "admin/gallery/create",
        method: "POST",
        timeout: 0,
        processData: false,
        mimeType: "multipart/form-data",
        contentType: false,
        data: payload,
        beforeSend: function (e) {
          $("#modal_loader_submit_file").show();
          if (e && e.overrideMimeType) {
            e.overrideMimeType("application/jsoncharset=UTF-8");
          }
        },
        complete: function () {
          $("#modal_loader_submit_file").hide();
        },
        error: function (xhr, ajaxOptions, thrownError) {
          alert(xhr.responseText);
        },
      })
      .done(function (result) {
          // console.log(result)
        var response = JSON.parse(result);
        if (response.status == true) {
          $("#modal_alert_submit_file").addClass("bg-success");
          $("#modal_alert_submit_file")
          .html("gallery sukses")
          .fadeIn()
          .delay(10000)
          .fadeOut();
          $hizb.gallery.show();
          $("#gallery_img_thumbnail").attr(
            "src",
            $base_url + "gallerys/no_image.jpg"
            );
          $("#file_gallery, #file_description").val("");
        } else {
            // $('#message_alert').html("");
            // var errors = response.message;
            // for(let index in errors){
            //     $('#message_alert').append("<li>"+errors[index]+"</li>");
            // }
            // $('#message_modal').modal('show');
        }
        $globFunc.ch_message_modal_modal(response.message);
      })
      .fail(function () {
          // An error occurred
        console.log(create);
      });
    },

    hapus_file_gallery: function (id) {
      $.ajax({
        url: $base_url + "admin/gallery/delete/" + id,
        method: "DELETE",
        timeout: 0,
        beforeSend: function (e) {
          $("#modal_loader_gallery").show();
          if (e && e.overrideMimeType) {
            e.overrideMimeType("application/jsoncharset=UTF-8");
          }
        },
        complete: function () {
          $("#modal_loader_gallery").hide();
        },
        success: function (response) {
          // console.log(response)
        },
        error: function (xhr, ajaxOptions, thrownError) {
          alert(xhr.responseText);
        },
      })
      .done(function (result) {
        var response = JSON.parse(result);
        console.log(response.status);
        if (response.status == true) {
          $hizb.gallery.show();
        }
      })
      .fail(function () {
          // An error occurred
      });
    },

    photos: {
      show: function () {
        // if ($globalVar.page == 'gallery') {
        //     var page = 'gallery/show';
        // }else{
        //     var page = $globalVar.page+'/show_gallery';
        // }
        var params = {
          // "url": $base_url+'/mygallery/photos/show',
          type: "get",
          action: "get",
          data: {
            limit: 0,
            offset: 0,
            sort: "id",
            order: "desc",
            search: "",
            created_by: true,
          },
          cache: true,
          contentType: "application/json",
          dataType: "json",
        };
        var url = $base_url + "/mygallery/photos/show";
        var ali = $hizb.ajax.ummay(url, params);
        ali
        .done(function (result) {
          var response = JSON.parse(result);
          $globFunc.ch_message_modal_modal(response.message);
          var data = response.rows;
          $("#album_gallery").empty();
          for (let index in data) {
            var $id = data[index].id;
            var id = data[index].id;
            var filename = data[index].filename;
            var description = data[index].description;
            var path = data[index].path;
            var file_url = data[index].file_url;

            if (filename == "") {
              var $filename = "no_image.jpg";
            } else {
              var $filename = filename;
            }

            if (description == "" || description == null) {
              var description_ = filename;
            } else {
              var description_ = description;
            }

              // var $element = '<div class="cont-checkbox mr-2">'+
              //     '<input type="checkbox" class="dorbitt_checkbox_image_gallery" name="dorbitt_checkbox_image_gallery" id="'+id+'" data-name="'+ filename +'" data-path="'+ path2 +'" />'+
              //     '<label for="'+id+'" class="lbl_gallery">'+
              //         '<img src="'+ path2 + '?crop=0.781xw:0.739xh;0.109xw,0.0968xh&resize=480:*"/>'+
              //         '<span class="cover-checkbox">'+
              //             '<svg viewBox="0 0 12 10">'+
              //                 '<polyline points="1.5 6 4.5 9 10.5 1"></polyline>'+
              //             '</svg>'+
              //         '</span>'+
              //         '<div class="info">'+ description_ +'</div>'+
              //     '</label>'+
              // '</div>';
              // // $('#album_gallery').append($element);

            var html =
            '<div class="col-md-2" id="mygallery_frame' +
            id +
            '">' +
            '<div class="card mb-4 shadow-sm">' +
                // '<svg class="bd-placeholder-img card-img-top" width="100%" height="225" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: Thumbnail" preserveAspectRatio="xMidYMid slice" focusable="false">'+
                //     '<title>Placeholder</title>'+
                //     '<rect width="100%" height="100%" fill="#55595c" /><text x="50%" y="50%" fill="#eceeef" dy=".3em">Thumbnail</text>'+
                // '</svg>'+
            '<img src="' +
            file_url +
            '" class="img-thumbnail" alt="...">' +
            '<div class="card-body">' +
                // '<p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>'+
            '<div class="d-flex justify-content-between align-items-center">' +
            '<div class="btn-group">' +
                // '<button type="button" class="btn btn-sm btn-outline-secondary">View</button>'+
            '<button type="button" class="btn btn-sm btn-outline-primary"><i class="fas fa-edit"></i></button>' +
            '<button type="button" class="btn btn-sm btn-outline-danger" onclick="$hizb.mygallery.photos.delete(' +
            id +
            ');"><i class="fas fa-trash-alt"></i></button>' +
            "</div>" +
            '<small class="text-muted">9 mins</small>' +
            "</div>" +
            "</div>" +
            "</div>" +
            "</div>";
            $("#mygallery_album_photos").append(html);
          }

            // console.log(response)

            // $('.pilih-berkas').click(function(){
            //     var $data_name = $(this).data('name');
            //     $hizb.mygallery.input_id.val($data_name)
            //     $('#modal_gallery').modal('hide')
            //     $hizb.mygallery.image_id.attr('src', path2)
            // })
            // $('#modal_loader_gallery').hide();
        })
        .fail(function () {
            // An error occurred
        });
      },

      show_for_modal: function () {
        var params = {
          type: "get",
          action: "get",
          data: {
            limit: 0,
            offset: 0,
            sort: "id",
            order: "desc",
            search: "",
            created_by: true,
          },
          cache: true,
          contentType: "application/json",
          dataType: "json",
        };
        var url = $base_url + "/mygallery/photos/show";
        var ali = $globalAjax.ummay(url, params);
        ali
        .done(function (result) {
          var response = JSON.parse(result);
          $globFunc.ch_message_modal_modal(response.message);
          var data = response.rows;
          $("#album_gallery").empty();
          for (let index in data) {
            var $id = data[index].id;
            var id = data[index].id;
            var filename = data[index].filename;
            var description = data[index].description;
            var path = data[index].path;
            var file_url = data[index].file_url;

            if (filename == "") {
              var $filename = "no_image.jpg";
            } else {
              var $filename = filename;
            }

            if (description == "" || description == null) {
              var description_ = filename;
            } else {
              var description_ = description;
            }

            var $element =
            '<div class="cont-checkbox p-2">' +
            '<input type="checkbox" class="dorbitt_checkbox_image_gallery" name="dorbitt_checkbox_image_gallery" id="' +
            id +
            '" data-name="' +
            filename +
            '" data-path="' +
            file_url +
            '" />' +
            '<label for="' +
            id +
            '" class="lbl_gallery">' +
            '<img src="' +
            file_url +
            '?crop=0.781xw:0.739xh;0.109xw,0.0968xh&resize=480:*"/>' +
            '<span class="cover-checkbox">' +
            '<svg viewBox="0 0 12 10">' +
            '<polyline points="1.5 6 4.5 9 10.5 1"></polyline>' +
            "</svg>" +
            "</span>" +
            '<div class="info">' +
            description_ +
            "</div>" +
            "</label>" +
            "</div>";
            $("#album_gallery").append($element);
          }
            // $('.pilih-berkas').click(function(){
            //     var $data_name = $(this).data('name');
            //     $hizb.mygallery.input_id.val($data_name)
            //     $('#modal_gallery').modal('hide')
            //     $hizb.mygallery.image_id.attr('src', path2)
            // })
          $("#modal_loader_gallery").hide();
        })
        .fail(function () {
            // An error occurred
        });
      },

      btn_mygallery_photos_submit: function () {
        $("#btn_mygallery_photos_submit").on("click", function () {
          if ($("#file_upload").val() == "") {
            alert("Please choose file.");
          } else {
            var ali = $hizb.ajax.mygallery.photos.upload();
            ali.done(function (result) {
              var response = JSON.parse(result);
              console.log(response);

              var html =
              '<div class="col-md-2">' +
              '<div class="card mb-4 shadow-sm">' +
                // '<svg class="bd-placeholder-img card-img-top" width="100%" height="225" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: Thumbnail" preserveAspectRatio="xMidYMid slice" focusable="false">'+
                //     '<title>Placeholder</title>'+
                //     '<rect width="100%" height="100%" fill="#55595c" /><text x="50%" y="50%" fill="#eceeef" dy=".3em">Thumbnail</text>'+
                // '</svg>'+
              '<img src="' +
              response.data.url +
              '" class="img-thumbnail" alt="...">' +
              '<div class="card-body">' +
                // '<p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>'+
              '<div class="d-flex justify-content-between align-items-center">' +
              '<div class="btn-group">' +
              '<button type="button" class="btn btn-sm btn-outline-secondary">View</button>' +
              '<button type="button" class="btn btn-sm btn-outline-secondary">Edit</button>' +
              "</div>" +
              '<small class="text-muted">9 mins</small>' +
              "</div>" +
              "</div>" +
              "</div>" +
              "</div>";
              $("#mygallery_album_photos").prepend(html);

              $(".custom-file label").html("Choose file");
              $("#file_upload").val("");
            });
          }
        });
      },

      btn_mygallery_photos_submit_on_modal: function () {
        $("#modal_mygallery #btn_submit_file_upload").on("click", function () {
          if ($("#file_upload").val() == "") {
            alert("Please choose file.");
          } else {
            var ali = $hizb.ajax.mygallery.photos.upload();
            ali.done(function (result) {
              var response = JSON.parse(result);
              console.log(response);

              if (response.status == true) {
                var html =
                '<div class="cont-checkbox">' +
                '<input type="checkbox" class="dorbitt_checkbox_image_gallery" name="dorbitt_checkbox_image_gallery" id="' +
                response.data.id +
                '" data-name="' +
                response.data.filename +
                '" data-path="' +
                response.data.url +
                '"/>' +
                '<label for="' +
                response.data.id +
                '" class="lbl_gallery">' +
                '<img src="' +
                response.data.url +
                '?crop=0.781xw:0.739xh;0.109xw,0.0968xh&resize=480:*"/>' +
                '<span class="cover-checkbox">' +
                '<svg viewBox="0 0 12 10">' +
                '<polyline points="1.5 6 4.5 9 10.5 1"></polyline>' +
                "</svg>" +
                "</span>" +
                '<div class="info">' +
                response.data.description +
                "</div>" +
                "</label>" +
                "</div>";
                $("#album_gallery").prepend(html);
                $(".custom-file label").html("Choose file");
                $("#file_upload").val("");
              }
            });
          }
        });
      },

      delete: function (id) {
        var params = {
          type: "delete",
          action: "delete",
          data: {},
          cache: true,
          contentType: "application/json",
          dataType: "json",
        };
        var url = $base_url + "/mygallery/photos/delete/" + id;
        var ali = $hizb.ajax.ummay(url, params);
        ali
        .done(function (result) {
          var response = JSON.parse(result);
          if (response.status == true) {
            $("#mygallery_frame" + id).remove();
          }
        })
        .fail(function () {
            // An error occurred
        });
      },
    },
  },

  views: {
    inputEmpty: function () {
      //
    },

    kosongkanForm: function () {
      $("#form_input_ruangan textarea").val("");
      $("#headerData .forBtnClear,select").val("");
      $(".forBtnClear").val("");
      $("#form_input_ruangan input,select").val("");
      $(".chk").prop("checked", false);
      $hizb.upload.ids = [];
    },

    clear_modal_form: function (a) {
      if (a) {
        if (a.includes("act") == true) {
          $("#modal_form .act-htmlcl").html("");
          $("#modal_form .act-valcl").val("");
          $("#modal_form .act-textareacl").val("");
          $("#modal_form .act-select2cl").val(null).trigger("change");
          $("#modal_form .act-radiocl").prop("checked", false);
          $("#modal_form .act-imgcl").prop(
            "src",
            $hizb.vars.base_url + $hizb.vars.no_image_path
            );
          $("#modal_form .lbl-inputfile-cl").html("Choose file");
        }
      } else {
        $("#modal_form .htmlcl").html("");
        $("#modal_form .valcl").val("");
        $("#modal_form .textareacl").val("");
        $("#modal_form .select2cl").val(null).trigger("change");
        $("#modal_form .radiocl").prop("checked", false);
        $("#modal_form .imgcl").prop(
          "src",
          $hizb.vars.base_url + $hizb.vars.no_image_path
          );
        $("#modal_form .lbl-inputfile-cl").html("Choose file");
      }
      // <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
      // <button type="button" class="btn btn-sm btn-warning" id="modal_btn_edit"><i class="fas fa-edit"></i> Edit</button>
      // <button type="button" class="btn btn-sm btn-primary btn-save" disabled><i class="fas fa-save"></i> Save changes</button>
    },

    set_value_to_form: function (row, index) {
      $("#gedung").val(row.gedung_id).change();
      $("#kode").val(row.kode);
      $("#name").val(row.name);
      $("#lantai").val(row.lantai);
      $("#jumlah_seat").val(row.seat);
      $("#type").val(row.type_id).change();
      $("#category").val(row.room_category_id).change();

      if (row.proyektor == 1) {
        $("#proyektor").prop("checked", true);
        globalVars.proyektor = 1;
      } else {
        globalVars.proyektor = 0;
      }

      if (row.whiteboard == 1) {
        $("#whiteboard").prop("checked", true);
        globalVars.whiteboard = 1;
      } else {
        globalVars.whiteboard = 0;
      }

      $("#carousel_foto_ruangan, #carousel_indicator").empty();
      var rows = row.images;
      if (rows) {
        for (let index in rows) {
          if (index == 0) {
            var aktif = "active";
          } else {
            var aktif = "";
          }

          var indicator =
          '<li data-target="#carouselExampleCaptions" data-slide-to="' +
          index +
          '" class="' +
          aktif +
          '"></li>';

          var html =
          '<div class="carousel-item ' +
          aktif +
          '">' +
          '<img src="' +
          $base_url +
          "uploads/" +
          rows[index] +
          '" class="d-block w-100 dorbitt-scale img-thumbnail" alt="...">' +
            // '<div class="carousel-caption d-none d-md-block">'+
            //     '<h5>First slide label</h5>'+
            //     '<p>Some representative placeholder content for the first slide.</p>'+
            // '</div>'+
          "</div>";

          $("#carousel_indicator").append(indicator);
          $("#carousel_foto_ruangan").append(html);
        }
      } else {
        // var html = '<div class="carousel-item active">'+
        //                 '<img src="'+$base_url+'uploads/sc1.png" class="d-block w-100 dorbitt-scale img-thumbnail" alt="...">'+
        //                 '<div class="carousel-caption d-none d-md-block">'+
        //                     '<h5>First slide label</h5>'+
        //                     '<p>Some representative placeholder content for the first slide.</p>'+
        //                 '</div>'+
        //             '</div>';
        // $('#carousel_foto_ruangan').append(html)
        app.Views.defautlFotoRuangan();
      }
    },

    set_value_to_option_gedung: function (params) {
      var rows = params.rows;
      var element_id = params.element_id;
      var kode = params.kode;

      $("#" + element_id).empty();
      $("#" + element_id).append(
        "<option value='' selected disabled>Choose...</option>"
        );
      for (let index in rows) {
        if (kode == 1) {
          var text = rows[index].kode + " - " + rows[index].name;
        } else {
          var text = rows[index].name;
        }
        $("#" + element_id).append(
          "<option data-lantai='" +
          rows[index].jumlah_lantai +
          "' value='" +
          rows[index].id +
          "'>" +
          text +
          "</option>"
          );
      }
    },

    set_value_to_table: function (method, id) {
      var row = {
        id: id,
        gedung_name: $("#gedung option:selected").text(),
        lantai: $("#lantai").val(),

        kode: $("#kode").val(),
        name: $("#name").val(),
        type_id: $("#type").val(),
        type_name: $("#type option:selected").text(),
        room_category_id: $("#category").val(),
        category_name: $("#category option:selected").text(),

        seat: $("#jumlah_seat").val(),
        proyektor: globalVars.proyektor,
        whiteboard: globalVars.whiteboard,
      };

      if (method == "insert") {
        $table.bootstrapTable("insertRow", {
          index: 0,
          row: row,
        });
      } else {
        $table.bootstrapTable("updateRow", {
          index: globalVars.dataIndex,
          row: row,
        });
      }
    },

    set_gallery_selected_to_img: function (rows) {
      // console.log(rows)
      $("#carousel_foto_ruangan, #carousel_indicator").empty();
      if (rows) {
        for (let index in rows) {
          // console.log(index)
          if (index == 0) {
            var aktif = "active";
          } else {
            var aktif = "";
          }

          var indicator =
          '<li data-target="#carouselExampleCaptions" data-slide-to="' +
          index +
          '" class="' +
          aktif +
          '"></li>';

          var html =
          '<div class="carousel-item ' +
          aktif +
          '">' +
          '<img src="' +
          $base_url +
          "uploads/" +
          rows[index] +
          '" class="d-block w-100 dorbitt-scale img-thumbnail" alt="...">' +
            // '<div class="carousel-caption d-none d-md-block">'+
            //     '<h5>First slide label</h5>'+
            //     '<p>Some representative placeholder content for the first slide.</p>'+
            // '</div>'+
          "</div>";

          $("#carousel_indicator").append(indicator);
          $("#carousel_foto_ruangan").append(html);
        }
      } else {
        // var html = '<div class="carousel-item active">'+
        //                 '<img src="'+$base_url+'uploads/sc1.png" class="d-block w-100 dorbitt-scale img-thumbnail" alt="...">'+
        //                 '<div class="carousel-caption d-none d-md-block">'+
        //                     '<h5>First slide label</h5>'+
        //                     '<p>Some representative placeholder content for the first slide.</p>'+
        //                 '</div>'+
        //             '</div>';
        // $('#carousel_foto_ruangan').append(html)
        app.Views.defautlFotoRuangan();
      }
    },

    defautlFotoRuangan: function () {
      var html =
      '<div class="carousel-item active">' +
      '<img src="' +
      $base_url +
      'uploads/sc1.png" class="d-block w-100 dorbitt-scale img-thumbnail" alt="...">' +
      '<div class="carousel-caption d-none d-md-block">' +
      "<h5>First slide label</h5>" +
      "<p>Some representative placeholder content for the first slide.</p>" +
      "</div>" +
      "</div>";
      $("#carousel_foto_ruangan").append(html);
    },

    images: {
      default_dorbitt_avatar: function () {
        var dorbitt_avatar = $("#dorbitt_avatar img").data("origin");
        $("#dorbitt_avatar img").prop("src", dorbitt_avatar);
      },

      default_accset_avatar: function () {
        var accset_avatar = $("#accset_avatar img").data("origin");
        $("#accset_avatar img").prop("src", accset_avatar);
        $("#avatar_filename").val("");
      },
    },

    resdel: function () {
      $("#response_deleted").modal("show");
    },

    modal: {
      fullscreen: function (element_id) {
        var el = $(element_id);
        var hasClass = el.hasClass("modal-fullscreen");
        console.log(hasClass);

        if (hasClass == true) {
          el.removeClass("modal-fullscreen");
        } else {
          el.addClass("modal-fullscreen");
        }
      },
      res_del: function () {},
      form_filter: function () {
        var html =
        '<div class="modal fade" id="modal_import" tabindex="-2" style="z-index: 3000;">' +
        '<div class="modal-dialog modal-dialog-centeredz">' +
        '<div class="modal-content">' +
        '<div class="modal-header bg-secondary">' +
        '<h5 class="modal-title text-light" id="message_title">Import</h5>' +
        '<button type="button" class="btn-close bg-light" data-bs-dismiss="modal" aria-label="Close"></button>' +
        "</div>" +
        '<div class="alert text-light collapse" id="modal_alert_import"></div>' +
        '<div class="collapse" id="loader">' +
        '<div class="d-flex justify-content-center mt-2">' +
        '<div class="spinner-border text-danger" role="status">' +
        '<span class="sr-only">Loading...</span>' +
        "</div>" +
        "</div>" +
        "</div>" +
        '<div class="modal-body">' +
        '<div id="form_import">' +
        '<form enctype="multipart/form-data" id="form_import_file">' +
        '<div class="col-md-12">' +
        '<label class="form-label">File</label>' +
        '<input class="form-control" type="file" name="file" id="file_import">' +
        "</div>" +
        "</form>" +
        "</div>" +
        '<div class="mt-3">' +
        '<a class="text-sm" target="_blank" id="link_format_import">' +
        '<i class="fas fa-file-excel"></i>' +
        "Click for download format import file" +
        "</a>" +
        "</div>" +
        "</div>" +
        '<div class="modal-footer">' +
        '<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>' +
        '<a href="#" type="button" class="btn btn-primary" id="btnImport" onclick="au_import();">Import</a>' +
        "</div>" +
        "</div>" +
        "</div>" +
        "</div>";
      },
    },

    approval: {
      status_detail: function (status) {
        $(
          ".dorbitt-detail .rad-approve, .dorbitt-detail .rad-pending, .dorbitt-detail .rad-reject"
          ).prop("checked", false);
        $(
          ".dorbitt-detail .rad-approve, .dorbitt-detail .rad-pending, .dorbitt-detail .rad-reject"
          ).prop("disabled", false);

        if (status == 1) {
          //approve
          $(".dorbitt-detail .rad-approve").prop("checked", true);
          $(".dorbitt-detail .rad-pending").prop("disabled", true);
        }

        if (status == 2) {
          //reject
          $(".dorbitt-detail .rad-reject").prop("checked", true);
          $(".dorbitt-detail .rad-approve, .dorbitt-detail .rad-pending").prop(
            "disabled",
            true
            );
        }

        if (status == 3) {
          //pending
          $(".dorbitt-detail .rad-pending").prop("checked", true);
          $(".dorbitt-detail .rad-reject").prop("disabled", true);
        }
      },

      status_detail_on_load: function (status) {
        // $('.dorbitt-detail .rad-approve, .dorbitt-detail .rad-pending, .dorbitt-detail .rad-reject').prop('checked', false);
        $(
          ".dorbitt-detail .rad-approve, .dorbitt-detail .rad-pending, .dorbitt-detail .rad-reject"
          ).prop("disabled", false);

        if (status == 1) {
          //approve
          // $('.dorbitt-detail .rad-approve').prop('checked', true);
          $(".dorbitt-detail .rad-pending").prop("disabled", true);
        }

        if (status == 2) {
          //reject
          // $('.dorbitt-detail .rad-reject').prop('checked', true);
          $(".dorbitt-detail .rad-approve, .dorbitt-detail .rad-pending").prop(
            "disabled",
            true
            );
        }

        if (status == 3) {
          //pending
          // $('.dorbitt-detail .rad-pending').prop('checked', true);
          $(".dorbitt-detail .rad-reject").prop("disabled", true);
        }
      },

      sumLoad: function (data) {
        if (data) {
          // Outstanding <span class="badge badge-pill badge-primary">0</span>
          $("#dorbitt_tabs #outstanding-pill").html(
            'Outstanding <span class="badge badge-pill badge-primary">' +
            data.jOutstanding +
            "</span>"
            );
          $("#dorbitt_tabs #pending-pill").html(
            'Pending <span class="badge badge-pill badge-warning">' +
            data.jPending +
            "</span>"
            );
          $("#dorbitt_tabs #reject-pill").html(
            'Reject <span class="badge badge-pill badge-danger">' +
            data.jReject +
            "</span>"
            );
        } else {
          $("#dorbitt_tabs #outstanding-pill").html(
            'Outstanding <div class="spinner-grow spinner-grow-sm text-primary" role="status">' +
            '<span class="sr-only">Loading...</span>' +
            "</div>"
            );
          $("#dorbitt_tabs #pending-pill").html(
            'Pending <div class="spinner-grow spinner-grow-sm text-warning" role="status">' +
            '<span class="sr-only">Loading...</span>' +
            "</div>"
            );
          $("#dorbitt_tabs #reject-pill").html(
            'Reject <div class="spinner-grow spinner-grow-sm text-danger" role="status">' +
            '<span class="sr-only">Loading...</span>' +
            "</div>"
            );
        }
      },

      button: {
        approve_all: function () {
          if ($hizb.dt.select.count() > 0) {
            table.button(1).enable();
          } else {
            table.button(1).disable();
          }
        },
      },
    },

    sidebar: {
      info_badge: function ($element_id, value) {
        var menuName = $("#" + element_id).html();
        $("#" + element_id).html(
          menuName +
          ' <span class="badge badge-pill badge-info float-right">' +
          value +
          "</span>"
          );
      },

      show_by_category: function () {
        // if (localStorage.getItem('enmod__category_id')) {}
      },
    },

    button: {
      endis: function (element_id, status) {
        if (status == true) {
          $(element_id).prop("disabled", false);
        } else {
          $(element_id).prop("disabled", true);
        }
      },

      delete_selected(key) {
        if ($hizb.dt.select.count() > 0) {
          table.button(key).enable();
        } else {
          table.button(key).disable();
        }
      },

      std_shb: {
        onNew: function () {
          $("#dbtn_new").attr("disabled", true);
          $("#dbtn_edit").attr("disabled", true);
          $("#dbtn_del").attr("disabled", true);
          $("#dbtn_can").attr("disabled", false);
          $("#dbtn_save").attr("disabled", false);
          $("#dbtn_print").attr("disabled", true);
          $("#dbtn_close").attr("disabled", true);
          $(".dis-able").attr("disabled", false);
          $(".input-form").attr("readonly", false);
        },
        onCan: function () {
          $(".dis-able").val("");
          $(".cnclear").val("");
          $("#dbtn_new").attr("disabled", false);
          $("#dbtn_edit").attr("disabled", true);
          $("#dbtn_del").attr("disabled", true);
          $("#dbtn_can").attr("disabled", true);
          $("#dbtn_save").attr("disabled", true);
          $("#dbtn_print").attr("disabled", true);
          $("#dbtn_close").attr("disabled", false);
          $(".dis-able").attr("disabled", true);
          $(".input-form").attr("readonly", true);
        },
      },

      standard_shb_on_select() {
        $("#dbtn_new").attr("disabled", false);
        $("#dbtn_edit").attr("disabled", false);
        $("#dbtn_del").attr("disabled", false);
        $("#dbtn_can").attr("disabled", true);
        $("#dbtn_save").attr("disabled", true);
        $("#dbtn_print").attr("disabled", false);
        $("#dbtn_close").attr("disabled", false);
      },

      shb_btn_std(nw, edit, del, can, save, print, close) {
        if (nw === false) {
          snw = "disabled";
        } else {
          snw = "";
        }

        // if (edit === false) {
        //     sedit = 'disabled'
        // }else{
        //     sedit = ''
        // }

        // if (del === false) {
        //     sdel = 'disabled'
        // }else{
        //     sdel = ''
        // }

        var html =
        '<button class="btn btn-sm btn-primary mb-1 mr-1" type="button" id="dbtn_new" ' +
        snw +
        '><i class="fab fa-wpforms"></i> New</button>' +
        '<button class="btn btn-sm btn-primary mb-1 mr-1" type="button" id="dbtn_edit" disabled><i class="fal fa-edit"></i> Edit</button>' +
        '<button class="btn btn-sm btn-primary mb-1 mr-1" type="button" id="dbtn_del" disabled><i class="fal fa-trash-alt"></i> Del</button>' +
        '<button class="btn btn-sm btn-primary mb-1 mr-1" type="button" id="dbtn_can" disabled><i class="fal fa-times"></i> Can</button>' +
        '<button class="btn btn-sm btn-primary mb-1 mr-1" type="button" id="dbtn_save" disabled><i class="fal fa-save"></i> Save</button>' +
        '<button class="btn btn-sm btn-primary mb-1 mr-1" type="button" id="dbtn_print" disabled><i class="fal fa-print"></i> Print</button>' +
        '<button class="btn btn-sm btn-primary mb-1 mr-1" type="button" id="dbtn_close"><i class="fal fa-sign-out-alt"></i> Close</button>';
        // return html;
        $("#btn_std_shb").html(html);
      },

      dt: {
        crud: function (action = null) {
          // var crud = JSON.parse($hizb.vars.crud);
          var text = $hizb.cookie.getCookie("crud");
          // var crud = text.replaceAll("-", ",");
          if (text != "" || text != 0) {
            var crud = text.split("-");
          } else {
            var crud = "";
          }

          var count_selc = $hizb.dt.select.count();
          console.log(crud);

          // c,rall,u,d,admin
          // 0,1   ,2,3,4

          if (crud) {
            if (crud[0] == 1) {
              if (count_selc == 1) {
                table.button("#btn_new").disable();
                table.button("#dt_btn_new").disable();
              } else if (count_selc > 1) {
                table.button("#btn_new").disable();
                table.button("#dt_btn_new").disable();
              } else {
                table.button("#btn_new").enable();
                table.button("#dt_btn_new").enable();
              }

              if (action == "new") {
                $(".modal_btn_edit").prop("disabled", true);
                $(".modal_btn_save").prop("disabled", false);
              }
            } else {
              table.button("#btn_new").disable();
              table.button("#dt_btn_new").disable();
            }

            if (crud[2] == 1) {
              if (count_selc == 1) {
                table.button("#dt_btn_edit").enable();
              } else if (count_selc > 1) {
                table.button("#dt_btn_edit").disable();
              } else {
                table.button("#dt_btn_edit").disable();
              }

              if (action == "edit") {
                $(".modal_btn_edit").prop("disabled", false);
                $(".modal_btn_save").prop("disabled", true);
              }
            } else {
              table.button("#dt_btn_edit").disable();
            }

            if (crud[3] == 1) {
              if (count_selc > 0) {
                table.button("#dt_btn_delete").enable();
              } else {
                table.button("#dt_btn_delete").disable();
              }
            } else {
              table.button("#dt_btn_delete").disable();
            }
          } else {
            table.button("#dt_btn_new").enable();
            table.button("#dt_btn_edit").disable();
            table.button("#dt_btn_delete").disable();
          }

          if ($hizb.vars.module_kode == "event_recruitment") {
            if (count_selc == 1) {
              table.button("#dt_btn_open_recruitment").enable();
            } else {
              table.button("#dt_btn_open_recruitment").disable();
            }
          }

          if ($hizb.vars.module_kode == "she_hazard_report") {
            if (count_selc >= 1) {
              table.button("#btn_release").enable();
            } else {
              table.button("#btn_release").disable();
            }
          }

          // table.button('#btn_edit').disable();
          // table.button('#btn_approve').disable();
          // table.button('#btn_reject').disable();
          // table.button('#btn_release').disable();
          // table.button('#btn_multi_delete').disable();
        },

        crud_hzr: function (action = null) {
          // var crud = JSON.parse($hizb.vars.crud);
          var text = $hizb.cookie.getCookie("crud");
          var a = $hizb.vars.nav_tab;

          // var crud = text.replaceAll("-", ",");
          if (text != "" || text != 0) {
            var crud = text.split("-");
          } else {
            var crud = "";
          }

          var count_selc = $hizb.dt.select.count();
          // console.log(crud);
          // console.log(crud);
          // console.log(count_selc);

          // c,rall,u,d,admin
          // 0,1   ,2,3,4

          // if (crud) {
          //     if (crud[0] == 1) {
          //         if (count_selc == 1) {
          //             table.button('#btn_new').disable();
          //             table.button('#dt_btn_new').disable();
          //         }else if (count_selc > 1) {
          //             table.button('#btn_new').disable();
          //             table.button('#dt_btn_new').disable();
          //         }else{
          //             table.button('#btn_new').enable();
          //             table.button('#dt_btn_new').enable();
          //         }

          //         if (action == 'new') {
          //             $('.modal_btn_edit').prop('disabled', true);
          //             $('.modal_btn_save').prop('disabled', false);
          //         }
          //     }else{
          //         table.button('#btn_new').disable();
          //         table.button('#dt_btn_new').disable();
          //     }

          //     if (crud[2] == 1) {
          //         if (count_selc == 1) {
          //             table.button('#dt_btn_edit').enable();
          //         }else if (count_selc > 1) {
          //             table.button('#dt_btn_edit').disable();
          //         }else{
          //             table.button('#dt_btn_edit').disable();
          //         }

          //         if (action == 'edit') {
          //             $('.modal_btn_edit').prop('disabled', false);
          //             $('.modal_btn_save').prop('disabled', true);
          //         }
          //     }else{
          //         table.button('#dt_btn_edit').disable();
          //     }

          //     if (crud[3] == 1) {
          //         if (count_selc > 0) {
          //             table.button('#dt_btn_delete').enable();
          //         }else{
          //             table.button('#dt_btn_delete').disable();
          //         }
          //     }else{
          //         table.button('#dt_btn_delete').disable();
          //     }
          // }else{
          //     table.button('#dt_btn_new').enable();
          //     table.button('#dt_btn_edit').disable();
          //     table.button('#dt_btn_delete').disable();
          // }

          // if ($hizb.vars.module_kode == 'event_recruitment') {
          //     if (count_selc == 1) {
          //         table.button('#dt_btn_open_recruitment').enable();
          //     }else{
          //         table.button('#dt_btn_open_recruitment').disable();
          //     }
          // }

          // if ($hizb.vars.module_kode == 'she_hazard_report') {
          //     if (count_selc >= 1) {
          //         table.button('#btn_release').enable();
          //     }else{
          //         table.button('#btn_release').disable();
          //     }
          // }

          // table.button('#btn_edit').disable();
          // table.button('#btn_approve').disable();
          // table.button('#btn_reject').disable();
          // table.button('#btn_release').disable();
          // table.button('#btn_multi_delete').disable();

          // c,rall,u,d,admin
          // 0,1   ,2,3,4

          // console.log(crud)

          if (a === 0 || a === 3) {
            if ($hizb.dt.select.count() > 0) {
              table.button("#dt_btn_new").disable();
              table.button("#dt_btn_edit").disable();
              table.button("#dt_btn_release").enable();
              table.button("#dt_btn_delete").enable();
            } else {
              table.button("#dt_btn_new").enable();
              table.button("#dt_btn_edit").enable();
              table.button("#dt_btn_release").disable();
              table.button("#dt_btn_delete").disable();
            }
            // $hizb.views.button.dt.showhide_edit();

            if ($hizb.dt.select.count() == 1) {
              table.button("#dt_btn_edit").enable();
            } else {
              table.button("#dt_btn_edit").disable();
            }
          }

          if (a == 1) {
            if (crud) {
              if (crud[4] == 1) {
                if ($hizb.dt.select.count() > 0) {
                  table.button("#dt_btn_approve").enable();
                  table.button("#dt_btn_reject").enable();
                } else {
                  table.button("#dt_btn_approve").disable();
                  table.button("#dt_btn_reject").disable();
                }
              }
            }
          }
        },

        showhide1: function () {
          if ($hizb.dt.select.count() > 0) {
            table.button(3).disable();
            table.button(5).enable();
            table.button(6).enable();
          } else {
            table.button(3).enable();
            table.button(5).disable();
            table.button(6).disable();
          }
          $hizb.views.button.dt.showhide_edit();
        },

        showhide2: function () {
          var a = $hizb.vars.nav_tab;
          // var crud = JSON.parse($hizb.vars.crud);
          var text = $hizb.cookie.getCookie("crud");
          if (text != "" || text != 0) {
            var crud = text.split("-");
          } else {
            var crud = "";
          }

          // c,rall,u,d,admin
          // 0,1   ,2,3,4

          // console.log(crud)

          if (a === 0 || a === 3) {
            if ($hizb.dt.select.count() > 0) {
              table.button("#btn_new").disable();
              table.button("#btn_edit").disable();
              table.button("#btn_release").enable();
              table.button("#btn_multi_delete").enable();
            } else {
              table.button("#btn_new").enable();
              table.button("#btn_edit").enable();
              table.button("#btn_release").disable();
              table.button("#btn_multi_delete").disable();
            }
            $hizb.views.button.dt.showhide_edit();
          }

          if (a == 1) {
            if (crud) {
              if (crud[4] == 1) {
                if ($hizb.dt.select.count() > 0) {
                  table.button("#btn_approve").enable();
                  table.button("#btn_reject").enable();
                } else {
                  table.button("#btn_approve").disable();
                  table.button("#btn_reject").disable();
                }
              }
            }
          }
        },

        showhide_edit: function () {
          if ($hizb.dt.select.count() == 1) {
            table.button("#btn_edit").enable();
          } else {
            table.button("#btn_edit").disable();
          }
        },
      },

      hazard_report: {
        on_modal_form_edit: function () {
          // console.log('ok');
          $(".modal_btn_edit").prop("disabled", true);
          $(".modal_btn_save").prop("disabled", false);
          $("#form_entry_data input, #form_entry_data button, select").prop("disabled", false);
          $("#tgl_penemuan, #waktu_penemuan").prop("disabled", true);
          // $('#modal_btn_edit').prop('disabled', true);
        },
      },

      recruitment: function () {
        $("#dt_btn_open_recruitment").prop("disabled", true);
      },
    },

    select_option_append: function (params) {
      var rows = params.rows;
      var element_id = params.element_id;
      var with_kode = params.with_kode;

      $("#" + element_id).empty();
      $("#" + element_id).append(
        "<option value='' selected disabled>Choose...</option>"
        );
      for (let index in rows) {
        if (with_kode == 1) {
          var text = rows[index].kode + " - " + rows[index].name;
        } else {
          var text = rows[index].name;
        }
        $("#" + element_id).append(
          "<option value='" + rows[index].id + "'>" + text + "</option>"
          );
      }
    },

    select_option_append2: function (params) {
      var rows = params.rows;
      var element_id = params.element_id;
      var id = "rows[index]." + params.id;
      var name = "rows[index]." + params.name;

      $("#" + element_id).empty();
      $("#" + element_id).append(
        "<option value='' selected disabled>Choose...</option>"
        );
      for (let index in rows) {
        $("#" + element_id).append(
          "<option value='" + eval(id) + "'>" + eval(name) + "</option>"
          );
      }
    },

    list_to_badge: function (index, row) {
      var html = row.kode + " | " + row.name;
      return html;
    },

    emailFormatter: function (data) {
      var email = "";
      if (data) {
        const array = data.split(",");
        $.each(array, function (index, val) {
          // console.log(index, val)
          email += '<a href="#" class="badge bg-primary">' + val + "</a><br> ";
          // var b += a;
        });
        // console.log(email);

        return email;
      }
    },

    hazard_report: {
      // btn_edit: function() {
      //     return '<button type="button" class="btn btn-primary btn-edit" id="modal_btn_edit">Edit</button>';
      // },
      // btn_approve: function() {
      //     return '<button type="button" class="btn btn-primary btn-approve" id="modal_btn_approve">Approve</button>';
      // },
      // btn_save: function() {
      //     return '<button type="button" class="btn btn-primary btn-save" id="modal_btn_save">Save Change</button>';
      // },

      button_in_modal_form: function (action = null) {
        $("#form_entry_data input, #form_entry_data button, select").prop(
          "disabled",
          true
          );
        $(".modal_btn_edit, .modal_btn_approve, .modal_btn_save").prop(
          "disabled",
          true
          );
        // <button type="button" class="btn btn-primary btn-edit" id="modal_btn_edit">Edit</button>
        // <button type="button" class="btn btn-primary btn-approve" id="modal_btn_approve">Approve</button>
        // <button type="button" class="btn btn-primary btn-save" id="modal_btn_save">Save Change</button>
        if (action == "new") {
          $(".modal_btn_save").prop("disabled", false);
          $("#form_entry_data input, #form_entry_data button, select").prop(
            "disabled",
            false
            );
          $("#tgl_penemuan, #waktu_penemuan").prop("disabled", true);
        } else {
          var tab = $hizb.vars.nav_tab;
          var crud = JSON.parse($hizb.vars.crud);

          // if (/*tab === 0 || */tab === 3 ) {
          //     if ($hizb.dt.select.count() > 0) {
          //         table.button('#btn_new').disable();
          //         table.button('#btn_edit').disable();
          //         table.button('#btn_release').enable();
          //         table.button('#btn_multi_delete').enable();

          //     }else{
          //         table.button('#btn_new').enable();
          //         table.button('#btn_edit').enable();
          //         table.button('#btn_release').disable();
          //         table.button('#btn_multi_delete').disable();
          //     }
          //     // $hizb.views.button.dt.showhide_edit();
          // }

          /*var btnEdit = '<button type="button" class="btn btn-primary btn-edit" id="modal_btn_edit" onclick="$hizb.views.button.hazard_report.on_modal_form_edit();">Edit</button> ';
                    var btnApprove = '<button type="button" class="btn btn-primary btn-approve" id="modal_btn_approve">Approve</button> ';
                    var btnSave = '<button type="button" class="btn btn-primary btn-save" id="modal_btn_save">Save Change</button> ';*/
          // console.log(crud);
          // $('#insideButton').html(btnEdit + btnApprove + btnSave);

          if (tab == 1) {
            if (crud) {
              if (crud.acc_admin == 1) {
                $(".modal_btn_approve").prop("disabled", false);
              }
            }
          }

          if (tab == 2) {
            // $('#form_entry_data input, #form_entry_data button, select').prop("disabled", true);
          }

          if (tab == 3) {
            // $('#form_entry_data input, #form_entry_data button, select').prop("disabled", true);
            // $('#tgl_penemuan, #waktu_penemuan').prop('disabled', true);
            // $('#insideButton').html(btnEdit + btnSave);
            $(".modal_btn_edit").prop("disabled", false);
          }
        }
      },

      btn_edit: function () {
        $(".modal_btn_edit, .modal_btn_approve, .modal_btn_save").prop(
          "disabled",
          true
          );
        $("#form_entry_data input, #form_entry_data button, select").prop(
          "disabled",
          false
          );
        $("#tgl_penemuan, #waktu_penemuan").prop("disabled", true);
        $(".modal_btn_save").prop("disabled", false);
      },

      /*modal_btn_edit: function() {
                var btnSave = '<button type="button" class="btn btn-primary btn-save" id="modal_btn_save">Save Change</button> ';
                $('#form_entry_data input, #form_entry_data button, select').prop("disabled", false);
                $('#tgl_penemuan, #waktu_penemuan').prop('disabled', true);
                $('#insideButton').html(btnSave);
            }*/

      layout: function () {
        table.buttons(".dt-btn-ummu").remove();

        if ($hizb.vars.nav_tab_id == "nav-released-tab") {
          var btn_status = ["approve", "reject"];
          
          $hizb.dt.layout.button(["btn_select_all", "btn_select_none"]);
          $hizb.dt.layout.button_crud(["new"]);
          $hizb.dt.layout.button_status(btn_status);
          // table.column(0).visible(true)
          // table.column(1).visible(false)
          $hizb.vars.dt.nth_child_onclick = 3;
        } 

        if ($hizb.vars.nav_tab_id == "nav-approved-tab") {

          $hizb.dt.layout.button();
          $hizb.dt.layout.button_crud(["new"]);
          $hizb.vars.dt.nth_child_onclick = 2;
        }

        if ($hizb.vars.nav_tab_id == "nav-rejected-tab") {
          $hizb.dt.layout.button(["btn_select_none"]);
          $hizb.dt.layout.button_crud(["new","edit"]);
          // table.column(0).visible(false)
          // table.column(1).visible(true)
          $hizb.vars.dt.nth_child_onclick = 2;
        }

        $hizb.dt.button.crud();
      },

      clearForm: function () {
        $("#status").html("");
        $("#modal_form input").val("");
        $("#modal_form textarea").val("");
        $(".status").prop("checked", false);
        $("#modal_form, select").val(null).trigger("change");
      },

      endis_form_edit: function () {
        // $('')
      }
    },

    dt: {
      info_filter: function (filter) {
        var html =
        '<span class=""><i class="fas fa-filter text-danger"></i> FILTER:</span> <br> ' +
        '<span class="text-info">From: </span><span class="badge badge-warning font-weight-normal">' +
        filter.datetime_detail.from +
        '</span> <span class="text-info">To: </span><span class="badge badge-warning font-weight-normal">' +
        filter.datetime_detail.to +
        " </span>";
        table.column(0).footer().innerHTML = html;
      },
    },

    sidebar: {
      show_or_hide: function () {
        var toggle_sidebar = localStorage.getItem("toggle_sidebar");
        if (toggle_sidebar == 1) {
          $("body").addClass("toggle-sidebar");
        } else {
          $("body").removeClass("toggle-sidebar");
        }
      },
    },

    errors_msg: function (errors) {
      $("#modal_message #alert").html("");

      if (typeof errors == 'string') {
        $("#modal_message #alert").append(errors);
      }else{
        var errors_value = Object.values(errors);
        // for(let index in errors_value){
        //   // $("#modal_message #alert").append("<div>- "+index+" is required</div>");
        //   $("#modal_message #alert").append(errors_value);
        // }
        // console.log(errors_value)

        for (const [key, value] of Object.entries(errors)) {
          // console.log(`${key}: ${value}`);
          $("#modal_message #alert").append("<div>- "+`${value}`+"</div>");
        }
      }

      $('#modal_message').modal('show');
    },
  },

  formatter: {
    date: {
      dateToYmd: function (data) {
        var d = new Date(data),
        month = "" + (d.getMonth() + 1),
        day = "" + d.getDate(),
        year = d.getFullYear();

        if (month.length < 2) month = "0" + month;
        if (day.length < 2) day = "0" + day;

        return [year, month, day].join("-");
      },
      dmyToYmd: function (dmy) {
        const myArray = dmy.split("-");

        var d = myArray[0];
        var m = myArray[1];
        var y = myArray[2];

        var new_dmy = y + "-" + m + "-" + d;

        var dt = new Date(new_dmy),
        month = "" + (dt.getMonth() + 1),
        day = "" + dt.getDate(),
        year = dt.getFullYear();

        if (month.length < 2) month = "0" + month;
        if (day.length < 2) day = "0" + day;

        return [year, month, day].join("-");
      },
      formatMicrosoftJSONDate: function(microsoftDate) {
        /*// Use a regular expression to extract the number inside /Date(...)
        var timestamp = parseInt(microsoftDate.replace(/[^0-9]/g, ''), 10);

        // Create a new Date object with the timestamp
        var date = new Date(timestamp);

        // Format the date to a readable string (e.g., YYYY-MM-DD)
        var year = date.getFullYear();
        var month = (date.getMonth() + 1).toString().padStart(2, '0'); // Months are zero-indexed
        var day = date.getDate().toString().padStart(2, '0');*/


        var timestamp = parseInt(microsoftDate.replace(/[^0-9]/g, ''), 10);
        var date = new Date(timestamp);

        var year = date.getFullYear();
        var month = (date.getMonth() + 1).toString().padStart(2, '0');
        var day = date.getDate().toString().padStart(2, '0');
        var hours = date.getHours().toString().padStart(2, '0');
        var minutes = date.getMinutes().toString().padStart(2, '0');
        var seconds = date.getSeconds().toString().padStart(2, '0');

        return `${year}-${month}-${day}`;
        // return `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;
      },
      MsJsonDate: function(microsoftDate) {
        var timestamp = parseInt(microsoftDate.replace(/[^0-9]/g, ''), 10);
        var date = new Date(timestamp);

        var year = date.getFullYear();
        var month = (date.getMonth() + 1).toString().padStart(2, '0');
        var day = date.getDate().toString().padStart(2, '0');
        var hours = date.getHours().toString().padStart(2, '0');
        var minutes = date.getMinutes().toString().padStart(2, '0');
        var seconds = date.getSeconds().toString().padStart(2, '0');

        return `${year}-${month}-${day}`;
      }
    },

    duration_menit: function (data) {
      return data + " menit";
    },

    is_release: function (data) {
      if (data == 1) {
        return '<i class="fas fa-check-square text-success"></i>';
      } else {
        return "";
      }
    },

    active: function (data) {
      if (data == 1) {
        return '<i class="fas fa-check-square text-success"></i>';
      } else {
        return "";
      }
    },

    sap: {
      operation: function (index, row) {
        // console.log(row)
        if (row) {
          return row.operation_kode + " | " + row.operation_name;
        }
      },
    },

    checked_if_value: function (data) {
      if (data == 1) {
        return '<i class="fas fa-check text-success"></i>';
      } else {
        return "";
      }
    },

    img_on_bt: function (data) {
      // console.log(data)
      if (data) {
        var res = '<img src="' + data + '" class="img-thumbnail">';
      } else {
        var res =
        '<img src="' +
        $base_url +
        "uploads/no_image.jpg" +
        '" class="img-thumbnail">';
        // var res = '<img src="' +$base_url+ 'uploads/no_image.jpg">';
      }

      return res;
    },

    obj_to_badge: function (data) {
      // console.log(data)
      var r = [];
      // $.each(data, function( index, value ) {
      //     r[index] = {};
      //     if (index == 0) {
      //         r[index] = '<span class="badge bg-primary">'+value.name+'</span>';
      //     }else{
      //         r[index] = '<br><span class="badge bg-primary">'+value.name+'</span>';
      //     }
      // });
      $.each(data, function (index, value) {
        r[index] = {};
        if (index == 0) {
          r[index] = index + 1 + ". " + value.name;
        } else {
          r[index] = "<br>" + (index + 1) + ". " + value.name;
        }
      });
      return (
        '<div style="overflow-y:scroll; max-height:100px !important;">' +
        r +
        "</div>"
        );
    },

    arr_to_badge: function (data) {
      // console.log(data)
      var r = [];

      /*$.each(data, function( index, value ) {
          r[index] = {};
          if (index == 0) {
              r[index] = '<span class="badge bg-primary">'+value+'</span>';
          }else{
              r[index] = '<br><span class="badge bg-primary">'+value+'</span>';
          }
      });*/

      if (data.length > 0) {
        $.each(data, function (index, value) {
          r[index] = {};

          if (index == 0) {
            r[index] = '<span class="badge badge-pill bg-primary text-light">1</span> ' + value;
          } else {
            r[index] = '<br> <span class="badge badge-pill bg-primary text-light">' + (index + 1) + '</span> ' + value;
          }
        });

        // return (
        //   '<div style="overflow-y:scroll; max-height:100px !important;">' +
        //   r +
        //   "</div>"
        //   );
        return (r);
      }else{
        return '';
      }

      // return data.length;


    },

    opr_detail: function () {
      return (
        '<a class="row-detail" id="row_detail" href="javascript:void(0)" title="Detail">' +
        '<i class="fas fa-caret-right"></i>' +
        "</a>"
        );
    },
  },

  render: {
    checked_if_value: function (data, type, row) {
      if (type === "myExport") {
        return data === "on" ? "Y" : "";
      }

      if (data === "on") {
        return '<i class="fas fa-check text-success"></i>';
      } else {
        return "";
      }
    },
  },

  validation: {
    keyup: function (element_id) {
      // $('#modal_response_message').html(msg);
      // if ($hizb.vars.error_ids === undefined || $hizb.vars.error_ids.length == 0) {
      //     $('#btn_approve').prop('disabled', false);
      // }else{
      //     $('#btn_approve').prop('disabled', true);
      // }

      var inArr = $hizb.vars.error_ids.includes(element_id);

      if (inArr == true) {
        $(element_id).addClass("text-danger");
      } else {
        $(element_id).removeClass("text-danger");
      }
    },

    keyup_false: function (element_id) {
      // $('#modal_response_message').html(msg);
      if ($hizb.vars.error_ids === undefined || $hizb.vars.error_ids.length == 0) {
        $("#btn_approve").prop("disabled", false);
      } else {
        $("#btn_approve").prop("disabled", true);
      }

      if ($hizb.vars.error_ids.includes(element_id) == true) {
        $(element_id).addClass("text-danger");
      } else {
        $(element_id).removeClass("text-danger");
      }
    },

    keyup_true: function (element_id) {
      // $('#modal_response_message').html(msg);
      if ($hizb.vars.error_ids === undefined || $hizb.vars.error_ids.length == 0) {
        $("#btn_approve").prop("disabled", false);
      } else {
        $("#btn_approve").prop("disabled", true);
      }

      if ($hizb.vars.error_ids.includes(element_id) == true) {
        $(element_id).addClass("text-danger");
      } else {
        $(element_id).removeClass("text-danger");
      }
    },

    form: function (element_id, button_id) {
      var inArr = $hizb.vars.error_ids.includes(element_id);

      if (inArr == true) {
        $(element_id).addClass("text-danger");
      } else {
        $(element_id).removeClass("text-danger");
      }

      if ($hizb.vars.error_ids === undefined || $hizb.vars.error_ids.length == 0) {
        $(button_id).prop("disabled", false);
      } else {
        $(button_id).prop("disabled", true);
      }
    },

    payslip_periode: {
      insert: function () {
        var name = $("#form_periode #name").val();
        if (name == "" || name == "undefined" || name == null || name == 0) {
          $("#name_msg_required").removeClass("collapse");
          $hizb.vars.errors.push("name");
          return false;
        } else {
          $("#name_msg_required").addClass("collapse");
          $hizb.vars.errors = $hizb.func.removeItem($hizb.vars.errors, "name");
          return true;
        }
      },
    },

    is_valid: function (value) {
      if (value == null || value == "" || value == "undefined") {
        $hizb.vars.required_field.push(false);
        return false;
      }
    },

    is_valid_date: function (value) {
      if (value == "0000-00-00" || moment(value, "YYYY-MM-DD", true).isValid() == false || value === "____-__-__") {
        $hizb.vars.required_field.push(false);
        return false;
      }
    },

    is_valid_time: function (value) {
      if (moment(value, "HH:mm", true).isValid() == false || value === "__:__") {
        $hizb.vars.required_field.push(false);
        return false;
      }
    },

    hazard_report: {
      insert: function () {
        $hizb.vars.required_field = [];
        $("#modal_message #alert").html("");

        var tgl_penemuan = $("#tgl_penemuan").val();
        if ($hizb.validation.is_valid_date(tgl_penemuan) == false) {
          $("#modal_message #alert").append(
            "<div>- Tanggal Penemuan not Valid</div>"
            );
        }

        var waktu_penemuan = $("#waktu_penemuan").val();
        if ($hizb.validation.is_valid_time(waktu_penemuan) == false) {
          $("#modal_message #alert").append(
            "<div>- Waktu Penemuan not Valid</div>"
            );
        }

        var lokasi_temuan_id = $("#lokasi_penemuan").val();
        if ($hizb.validation.is_valid(lokasi_temuan_id) == false) {
          $("#modal_message #alert").append(
            "<div>- Lokasi temuan required.</div>"
            );
        }

        var detail_lokasi = $("#detail_lokasi").val();
        if ($hizb.validation.is_valid(detail_lokasi) == false) {
          $("#modal_message #alert").append(
            "<div>- Detail lokasi required.</div>"
            );
        }

        var jenis_temuan_id = $("#jenis_temuan").val();
        if ($hizb.validation.is_valid(jenis_temuan_id) == false) {
          $("#modal_message #alert").append(
            "<div>- Jenis temuan required.</div>"
            );
        }

        var bahaya_ditemukan = $("#bahaya_ditemukan").val();
        if ($hizb.validation.is_valid(bahaya_ditemukan) == false) {
          $("#modal_message #alert").append(
            "<div>- Bahaya yang ditemukan required.</div>"
            );
        }

        var penyebab_bahaya = $("#penyebab_bahaya").val();
        if ($hizb.validation.is_valid(penyebab_bahaya) == false) {
          $("#modal_message #alert").append(
            "<div>- Penyebab bahaya required.</div>"
            );
        }

        var kode_bahaya_id = $("#kode_bahaya").val();
        if ($hizb.validation.is_valid(kode_bahaya_id) == false) {
          $("#modal_message #alert").append(
            "<div>- Kode bahayaq required.</div>"
            );
        }

        // var foto_temuan_id = $('#foto_temuan').attr('data-id');
        // if ($hizb.validation.is_valid(foto_temuan_id) == false) {
        //     $('#modal_message #alert').append('<div>- Foto temuan required.</div>');
        // }

        var rincian_tindakan = $("#rincian_tindakan").val();
        if ($hizb.validation.is_valid(rincian_tindakan) == false) {
          $("#modal_message #alert").append(
            "<div>- Rincian tindakan required.</div>"
            );
        }

        // var foto_perbaikan_id = $('#foto_perbaikan').attr('data-id');
        // if (foto_perbaikan_id == 'undefined') {
        //     $('#modal_message #alert').append('<div>- Foto perbaikan required.</div>');
        // }

        var status_id = $("input:radio[name=status]:checked").val();
        if ($hizb.validation.is_valid(status_id) == false) {
          $("#modal_message #alert").append("<div>- Status required.</div>");
        }

        var nm_atasan = $("#nm_atasan").val();
        if ($hizb.validation.is_valid(nm_atasan) == false) {
          $("#modal_message #alert").append(
            "<div>- Nama atasan required.</div>"
            );
        }

        if ($hizb.vars.required_field.includes(false)) {
          return false;
        }
      },

      reject: function () {
        $hizb.vars.required_field = [];
        $("#modal_message #alert").html("");

        var remark = $("#modal_reject_confirm #remark").val();
        if ($hizb.validation.is_valid(remark) == false) {
          $("#modal_message #alert").append("<div>- Remark required</div>");
        }

        if ($hizb.vars.required_field.includes(false)) {
          return false;
        }
      },
    },

    uom: {
      insert: function () {
        $hizb.vars.required_field = [];
        $("#modal_message #alert").html("");

        var material = $("#material").val();
        if ($hizb.validation.is_valid(material) == false) {
          $("#modal_message #alert").append("<div>- Material required.</div>");
        }

        var uom = $("#uom").val();
        if ($hizb.validation.is_valid(uom) == false) {
          $("#modal_message #alert").append("<div>- UoM required.</div>");
        }

        var expired_date = $("#expired_date").val();
        if ($hizb.validation.is_valid_date(expired_date) == false) {
          $("#modal_message #alert").append(
            "<div>- Expired Date not Valid</div>"
            );
        }

        var formularium_qty = $("#formularium_qty").val();
        if ($hizb.validation.is_valid(formularium_qty) == false) {
          $("#modal_message #alert").append(
            "<div>- Formularium Qty required.</div>"
            );
        }

        var qty = $("#qty").val();
        if ($hizb.validation.is_valid(qty) == false) {
          $("#modal_message #alert").append("<div>- Qty required.</div>");
        }

        var qty_on_site = $("#qty_on_site").val();
        if ($hizb.validation.is_valid(qty_on_site) == false) {
          $("#modal_message #alert").append(
            "<div>- Qty on site required.</div>"
            );
        }

        if ($hizb.vars.required_field.includes(false)) {
          return false;
        }
      },
    },

    medicine_stock: {
      insert: function () {
        $hizb.vars.required_field = [];
        $("#modal_message #alert").html("");

        var material = $("#material").val();
        if ($hizb.validation.is_valid(material) == false) {
          $("#modal_message #alert").append("<div>- Material required.</div>");
        }

        var uom = $("#uom").val();
        if ($hizb.validation.is_valid(uom) == false) {
          $("#modal_message #alert").append("<div>- UoM required.</div>");
        }

        var expired_date = $("#expired_date").val();
        if ($hizb.validation.is_valid_date(expired_date) == false) {
          $("#modal_message #alert").append(
            "<div>- Expired Date not Valid</div>"
            );
        }

        // var formularium_qty = $('#formularium_qty').val();
        // if ($hizb.validation.is_valid(formularium_qty) == false) {
        //     $('#modal_message #alert').append('<div>- Formularium Qty required.</div>');
        // }

        var qty = $("#qty").val();
        if ($hizb.validation.is_valid(qty) == false) {
          $("#modal_message #alert").append("<div>- Qty required.</div>");
        }

        // var qty_on_site = $('#qty_on_site').val();
        // if ($hizb.validation.is_valid(qty_on_site) == false) {
        //     $('#modal_message #alert').append('<div>- Qty on site required.</div>');
        // }

        var unit_price = $("#unit_price").val();
        var material_price = $("#material_price").data("ori");

        if (unit_price > material_price) {
          $("#modal_message #alert").append(
            "<div>- Unit Price exceeds the limit.</div>"
            );
        }

        if ($hizb.vars.required_field.includes(false)) {
          return false;
        }
      },
    },

    mechanic_activity: {
      insert: function () {
        $hizb.vars.required_field = [];
        $("#modal_message #alert").html("");

        // if ($hizb.validation.is_valid($('#plant').val()) == false) {
        //     $('#modal_message #alert').append('<div>- Plant required.</div>');
        // }

        if ($hizb.validation.is_valid($("#employee").val()) == false) {
          $("#modal_message #alert").append("<div>- Mechanic required.</div>");
        }

        if ($hizb.validation.is_valid($("#reason").val()) == false) {
          $("#modal_message #alert").append("<div>- Reason required.</div>");
        }

        if ($hizb.validation.is_valid($("#techIdNo").val()) == false) {
          $("#modal_message #alert").append("<div>- techIdNo required.</div>");
        }

        if ($hizb.validation.is_valid($("#wo_number").val()) == false) {
          $("#modal_message #alert").append(
            "<div>- Order Number required.</div>"
            );
        }

        if ($hizb.validation.is_valid($("#operation").val()) == false) {
          $("#modal_message #alert").append("<div>- Operation required.</div>");
        }

        if ($hizb.validation.is_valid_date($("#date_start").val()) == false) {
          $("#modal_message #alert").append(
            "<div>- Work Start Date required.</div>"
            );
        }

        if ($hizb.validation.is_valid_time($("#time_start").val()) == false) {
          $("#modal_message #alert").append(
            "<div>- Work Start Time required.</div>"
            );
        }

        if ($hizb.validation.is_valid_date($("#date_end").val()) == false) {
          $("#modal_message #alert").append(
            "<div>- Work End Date required.</div>"
            );
        }

        if ($hizb.validation.is_valid_time($("#time_end").val()) == false) {
          $("#modal_message #alert").append(
            "<div>- Work End Time required.</div>"
            );
        }

        if ($hizb.vars.required_field.includes(false)) {
          return false;
        }

        // if ($('#plant').val() === null) {
        //     $hizb.vars.errors.push("plant")
        // }

        // if ($('#wo_number').val() === null) {
        //     $hizb.vars.errors.push("wo_number")
        // }

        // if ($('#wo_number').val() === null) {
        //     $hizb.vars.errors.push("wo_number")
        // }

        // if ($('#techIdNo').val() === null) {
        //     $hizb.vars.errors.push("techIdNo")
        // }

        // if ($('#operation').val() === null) {
        //     $hizb.vars.errors.push("operation")
        // }

        // if ($('#employee').val() === null) {
        //     $hizb.vars.errors.push("mechanic")
        // }

        // if ($('#reason').val() === null) {
        //     $hizb.vars.errors.push("reason")
        // }

        // var date_start = $('#date_start').val();
        // if (date_start === null || date_start === '____-__-__') {
        //     $hizb.vars.errors.push("date_start")
        // }

        // var time_start = $('#time_start').val();
        // if (time_start === null || time_start === '__:__') {
        //     $hizb.vars.errors.push("time_start")
        // }

        // var date_end = $('#date_end').val();
        // if (date_end === null || date_end === '____-__-__') {
        //     $hizb.vars.errors.push("date_end")
        // }

        // var time_end = $('#time_end').val();
        // if (time_end === null || time_end === '__:__') {
        //     $hizb.vars.errors.push("time_end")
        // }

        // return $hizb.vars.errors;
      },
    },

    // insert: function () {
    //   $hizb.vars.required_field = [];
    //   $("#modal_message #alert").html("");

    //   if ($hizb.vars.required_field.includes(false)) {
    //     return false;
    //   }
    // },
  },

  bt: {
    initTable: function () {
      $table.bootstrapTable({
        locale: "en-US",
      });
      $table.on(
        "check.bs.table uncheck.bs.table check-all.bs.table uncheck-all.bs.table",
        function () {
          $("#remove").prop(
            "disabled",
            !$table.bootstrapTable("getSelections").length
            );
          $("#view").prop(
            "disabled",
            $table.bootstrapTable("getSelections").length != 1
            );
          $("#new").prop(
            "disabled",
            $table.bootstrapTable("getSelections").length
            );
          // save your data, here just save the current page
          seldata: dataections = $globFunc.getIdSelections();
        }
        );
      $table.on("all.bs.table", function (e, name, args) {
        console.log(name, args);
      });
      $("#remove").click(function () {
        app.Controllers.remove();
        // $('#btn_multiple_delete').attr('onclick','Routes.multiple_delete();')
        // $('#modal_confirmation_multiple_delete').modal('show')
      });
      $("#view").click(function () {
        // $('#modal_form').modal('show')
        app.Controllers.view();
      });
    },

    responseHandler: function (res) {
      $.each(res.rows, function (i, row) {
        row.state = $.inArray(row.id, selections) !== -1;
      });
      return res;
    },

    detailFormatter: function (index, row) {
      var html = [];
      $.each(row, function (key, value) {
        html.push("<p><b>" + key + ":</b> " + value + "</p>");
      });
      return html;
    },

    formatTotalPrice: function (data) {
      var field = this.field;
      return (
        "$" +
        data
        .map(function (row) {
          return +row[field].substring(1);
        })
        .reduce(function (sum, i) {
          return sum + i;
        }, 0)
        );
    },

    operateFormatter: function () {
      return [
        // '<a class="like" href="javascript:void(0)" title="Like">',
        //     '<i class="fa fa-heart"></i>',
        // '</a>  ',
        // '<a href="#" id="add" class="remove" data-bs-toggle="modal" data-bs-target="#modal_confirmation">',
        //     '<i class="fa fa-trash"></i>',
        // '</a>   ',
        '<a class="remove" href="javascript:void(0)" title="Remove">',
        '<i class="fa fa-trash"></i>',
        "</a>  ",
        '<a class="edit" href="javascript:void(0)" title="Edit">',
        '<i class="fas fa-edit"></i>',
        "</a>",
      ];
    },

    getIdSelections: function () {
      return $.map($table.bootstrapTable('getSelections'), function (row) {
        return row.id
      })
    },

    button: {
      crud: function () {
        return {
          // btnUsersAdd: {
          //     text: 'Highlight Users',
          //     icon: 'fa-users',
          //     event: function () {
          //         alert('Do some stuff to e.g. search all users which has logged in the last week')
          //     },
          //     attributes: {
          //         title: 'Search all users which has logged in the last week'
          //     }
          // },
          btn_new: {
            text: "Add new row",
            icon: "far fa-plus",
            event: function () {
              $("#modal_form").modal("show");
            },
            attributes: {
              title: "Add a new row to the table",
            },
          },
          btn_edit: {
            text: "Edit row",
            icon: "far fa-edit",
            event: function () {
              $("#modal_form").modal("show");
            },
            attributes: {
              title: "Edit a row from table",
            },
          },
          btn_delete: {
            text: "Delete rows",
            icon: "far fa-trash",
            event: function () {
              // $('#modal_form').modal('show');
            },
            attributes: {
              title: "Delete a row from table",
            },
          },
        };
      },
      sortable: function () {
        var buttonsOrder = [
          "paginationSwitch",
          "refresh",
          "toggle",
          "fullscreen",
          "columns",
          "export",
          "btn_new",
          "btn_edit",
          "btn_delete",
        ];
        $("#btUmmu").bootstrapTable("refreshOptions", {
          buttonsOrder: buttonsOrder,
        });
      },
    },
  },

  dt: {
    load: function () {
      $hizb.dt.var_id();
      $hizb.dt.button.crud();

      table.on("click", "tbody tr td:first-child", function () {
        $hizb.dt.var_id();
        $hizb.dt.button.crud();
      });

      table.on("dblclick", "tbody tr", function () {
        var row = table.row(this).data();
        $hizb.vars.id = row.id;
        // console.log(row);

        // $hizb.vars.site_project_kode = row.site_project_kode;
        // // $('#form_entry_data input, #form_entry_data button, select').prop("disabled", true);
        // // $('#form_entry_data input').prop('disabled', true);
        app.config.routes.dt_tbody_tr_dblclick(row);
        // $hizb.views.hazard_report.button_in_modal_form();
        // // $('#modal_btn_edit, #modal_btn_save')
      });

      table.on("select", function (e, dt, type, indexes) {
        $hizb.dt.var_id();
        $hizb.dt.button.crud();
      });

      table.on("deselect", function (e, dt, type, indexes) {
        $hizb.dt.var_id();
        $hizb.dt.button.crud();
      });

      table.on("mouseenter", "td", function () {
        let colIdx = table.cell(this).index().column;
        table
        .cells()
        .nodes()
        .each((el) => el.classList.remove("highlight"));

        table
        .column(colIdx)
        .nodes()
        .each((el) => el.classList.add("highlight"));
      });
    },

    select: {
      load: function () {
        table.on("click", "tbody tr td:first-child", function () {
          // if (table.row(':eq(0)').selected()) {
          //     $hizb.dt.button.crud();
          // }
          // else {
          //     $hizb.dt.button.crud();
          // }
          $hizb.dt.button.crud();
          $hizb.dt.button.trx();
          // console.log("OK")
        });

        table.on("dblclick", "tbody tr", function () {
          /*var row = table.row(this).data();
                    $hizb.vars.id = row.id;
                    $hizb.vars.site_project_kode = row.site_project_kode;
                    // $('#form_entry_data input, #form_entry_data button, select').prop("disabled", true);
                    // $('#form_entry_data input').prop('disabled', true);
                    app.controllers.edit(row);
                    $hizb.views.hazard_report.button_in_modal_form();
                    // $('#modal_btn_edit, #modal_btn_save')*/
        });

        table.on("select", function (e, dt, type, indexes) {
          $hizb.dt.button.crud();
          $hizb.dt.button.trx();
        });

        table.on("deselect", function (e, dt, type, indexes) {
          $hizb.dt.button.crud();
          $hizb.dt.button.trx();
        });

        // table.on('mouseenter', 'td', function () {
        //     let colIdx = table.cell(this).index().column;
        //     table
        //     .cells()
        //     .nodes()
        //     .each((el) => el.classList.remove('highlight'));

        //     table
        //     .column(colIdx)
        //     .nodes()
        //     .each((el) => el.classList.add('highlight'));
        // });

        // $hizb.dt.button.crud();
      },
      count: function () {
        return table.rows({ selected: true }).count();
      },
      data: function () {
        return table.rows({ selected: true }).data();
      },
      getRow: function (tbName) {
        return tbName.row({ selected: true }).data();
      },
    },

    button: {
      crud: function () {
        table.button("#dt_btn_new").disable();
        table.button("#dt_btn_edit").disable();
        table.button("#dt_btn_release").disable();
        table.button("#dt_btn_delete").disable();
        table.button("#dt_btn_approve").disable();
        table.button("#dt_btn_pending").disable();
        table.button("#dt_btn_reject").disable();

        var count_selc = $hizb.dt.select.count();
        if (count_selc == 1) {
          var rows = $hizb.dt.select.data();
          $hizb.vars.id = rows[0].id;
          // console.log(rows[0])
        } else if (count_selc > 1) {
          var rows = $hizb.dt.select.data();
        } else {
          $hizb.vars.id = null;
          $hizb.vars.ids = null;
        }

        var text = $hizb.vars.crud;
        var tab = $hizb.vars.nav_tab;
        // var nav_tab_id = localStorage.getItem('nav_tab_id');
        var nav_tab_id = $hizb.vars.nav_tab_id;
        if (text != "" || text != 0 || text != null) {
          var crud = text.split(",");
        } else {
          var crud = "";
        }

        if (crud) {
          if (crud[0] == 1) {
            if (count_selc < 1) {
              table.button("#dt_btn_new").enable();
            }
          }

          if (crud[2] == 1) {
            if (count_selc == 1) {
              table.button("#dt_btn_edit").enable();
            } else if (count_selc > 1) {
              table.button("#dt_btn_edit").disable();
            } else {
              table.button("#dt_btn_edit").disable();
            }

            // if (action == 'edit') {
            //     $('.modal_btn_edit').prop('disabled', false);
            //     $('.modal_btn_save').prop('disabled', true);
            // }
          }

          if (crud[3] == 1) {
            if (count_selc > 0) {
              table.button("#dt_btn_delete").enable();
            } else {
              table.button("#dt_btn_delete").disable();
            }
          }

          if ($hizb.vars.module_kode == "") {
            if (nav_tab_id == "nav-released-tab") {
              if ($hizb.dt.select.count() > 0) {
                // table.button('#dt_btn_new').disable();
                // table.button('#dt_btn_edit').disable();
                table.button("#dt_btn_approve").enable();
                table.button("#dt_btn_reject").enable();
                table.button("#dt_btn_delete").enable();
              }

              // if (crud[2] == 1) {
              //     $hizb.dt.button.edit();
              // }

              // if ($hizb.dt.select.count() == 1) {
              //     table.button('#dt_btn_edit').enable();
              // }else{
              //     table.button('#dt_btn_edit').disable();
              // }
              // console.log('nav-release-tab');
            }

            // if (tab == 1) {
            //     /**
            //      * pada tab Released List, dokument tidak bisa dilakukan Edit, Release dan Delete */
            //     if (crud[4] == 1) {
            //         if ($hizb.dt.select.count() > 0) {
            //             table.button('#dt_btn_approve').enable();
            //             table.button('#dt_btn_reject').enable();
            //         }
            //     }
            // }

            // if (crud[2] == 1) {
            //     if (count_selc == 1) {
            //         table.button('#dt_btn_edit').enable();
            //     }else if (count_selc > 1) {
            //         table.button('#dt_btn_edit').disable();
            //     }else{
            //         table.button('#dt_btn_edit').disable();
            //     }

            //     if (action == 'edit') {
            //         $('.modal_btn_edit').prop('disabled', false);
            //         $('.modal_btn_save').prop('disabled', true);
            //     }
            // }else{
            //     table.button('#dt_btn_edit').disable();
            // }
          }

          if ($hizb.vars.module_kode == "she_hazard_report") {
            table.button("#dt_btn_new").enable();
            table.button("#dt_btn_edit").disable();
            table.button("#dt_btn_release").disable();
            table.button("#dt_btn_delete").disable();
            table.button("#dt_btn_approve").disable();
            table.button("#dt_btn_pending").disable();
            table.button("#dt_btn_reject").disable();

            // console.log(crud);
            // console.log(crud);
            // console.log(count_selc);

            // c,rall,u,d,admin
            // 0,1   ,2,3,4

            /*if (crud) {
                if (crud[0] == 1) {
                    if (count_selc == 1) {
                        table.button('#btn_new').disable();
                        table.button('#dt_btn_new').disable();
                    }else if (count_selc > 1) {
                        table.button('#btn_new').disable();
                        table.button('#dt_btn_new').disable();
                    }else{
                        table.button('#btn_new').enable();
                        table.button('#dt_btn_new').enable();
                    }

                    if (action == 'new') {
                        $('.modal_btn_edit').prop('disabled', true);
                        $('.modal_btn_save').prop('disabled', false);
                    }
                }else{
                    table.button('#btn_new').disable();
                    table.button('#dt_btn_new').disable();
                }

                if (crud[2] == 1) {
                    if (count_selc == 1) {
                        table.button('#dt_btn_edit').enable();
                    }else if (count_selc > 1) {
                        table.button('#dt_btn_edit').disable();
                    }else{
                        table.button('#dt_btn_edit').disable();
                    }

                    if (action == 'edit') {
                        $('.modal_btn_edit').prop('disabled', false);
                        $('.modal_btn_save').prop('disabled', true);
                    }
                }else{
                    table.button('#dt_btn_edit').disable();
                }

                if (crud[3] == 1) {
                    if (count_selc > 0) {
                        table.button('#dt_btn_delete').enable();
                    }else{
                        table.button('#dt_btn_delete').disable();
                    }
                }else{
                    table.button('#dt_btn_delete').disable();
                }
            }else{
                table.button('#dt_btn_new').enable();
                table.button('#dt_btn_edit').disable();
                table.button('#dt_btn_delete').disable();
            }

            if ($hizb.vars.module_kode == 'event_recruitment') {
                if (count_selc == 1) {
                    table.button('#dt_btn_open_recruitment').enable();
                }else{
                    table.button('#dt_btn_open_recruitment').disable();
                }
            }

            if ($hizb.vars.module_kode == 'she_hazard_report') {
                if (count_selc >= 1) {
                    table.button('#btn_release').enable();
                }else{
                    table.button('#btn_release').disable();
                }
            }

            table.button('#btn_edit').disable();
            table.button('#btn_approve').disable();
            table.button('#btn_reject').disable();
            table.button('#btn_release').disable();
            table.button('#btn_multi_delete').disable();*/

            /**
             * crud[0] = create
             * crud[1] = read all
             * crud[2] = update
             * crud[3] = delete
             * crud[4] = admin*/

            /**
             * jika tab Not Release atau Rejected List active */
            if (nav_tab_id == "nav-notrelease-tab" || nav_tab_id == "nav-rejected-tab") {
              if ($hizb.dt.select.count() > 0) {
                table.button("#dt_btn_release").enable();

                if (crud[3] == 1) {
                  table.button("#dt_btn_delete").enable();
                }
              }

              if ($hizb.dt.select.count() == 1) {
                // table.button("#dt_btn_release").enable();
                table.button("#dt_btn_edit").enable();

                // if (crud[3] == 1) {
                //   table.button("#dt_btn_delete").enable();
                // }
              }

              // if (crud[2] == 1) {
              //     $hizb.dt.button.edit();
              // }

              // if ($hizb.dt.select.count() == 1) {
              //     table.button('#dt_btn_edit').enable();
              // }else{
              //     table.button('#dt_btn_edit').disable();
              // }
            }

            /**
             * Jika tab Released List active */
            if (nav_tab_id == "nav-released-tab") {
              /**
               * pada tab Released List, dokument tidak bisa dilakukan Edit, Release dan Delete */
              if (crud[4] == 1) {
                if ($hizb.dt.select.count() > 0) {
                  table.button("#dt_btn_approve").enable();
                  table.button("#dt_btn_reject").enable();
                }
              }
            }

            // if (crud[2] == 1) {
            //     if (count_selc == 1) {
            //         table.button('#dt_btn_edit').enable();
            //     }else if (count_selc > 1) {
            //         table.button('#dt_btn_edit').disable();
            //     }else{
            //         table.button('#dt_btn_edit').disable();
            //     }

            //     if (action == 'edit') {
            //         $('.modal_btn_edit').prop('disabled', false);
            //         $('.modal_btn_save').prop('disabled', true);
            //     }
            // }else{
            //     table.button('#dt_btn_edit').disable();
            // }
          }

          if ($hizb.vars.module_kode == "hcm_applicants") {
            table.button("#dt_btn_new").enable();
            table.button("#dt_btn_edit").disable();
            table.button("#dt_btn_release").disable();
            table.button("#dt_btn_delete").disable();
            table.button("#dt_btn_approve").disable();
            table.button("#dt_btn_pending").disable();
            table.button("#dt_btn_reject").disable();

            /**
             * crud[0] = create
             * crud[1] = read all
             * crud[2] = update
             * crud[3] = delete
             * crud[4] = admin*/
            /**

                        /**
                         * Jika tab Released List active */
            if (
              nav_tab_id == null ||
              nav_tab_id == "" ||
              nav_tab_id == "nav-released-tab"
              ) {
              /**
               * pada tab Released List, dokument bisa diapprove dan direject */
              if (crud[4] == 1) {
                if ($hizb.dt.select.count() > 0) {
                  table.button("#dt_btn_approve").enable();
                  table.button("#dt_btn_reject").enable();
                }
              }
            }
          }
        }

        // console.log('ok gas')
      },
      edit: function () {
        if ($hizb.dt.select.count() == 1) {
          table.button("#dt_btn_edit").enable();
        } else {
          table.button("#dt_btn_edit").disable();
        }
      },
      trx: function () {
        table.button("#dt_btn_history").disable();
        // table.button('#dt_btn_edit').disable();
        // table.button('#dt_btn_release').disable();
        // table.button('#dt_btn_delete').disable();
        // table.button('#dt_btn_approve').disable();
        // table.button('#dt_btn_pending').disable();
        // table.button('#dt_btn_reject').disable();

        var count_selc = $hizb.dt.select.count();
        if (count_selc == 1) {
          var rows = $hizb.dt.select.data();
          $hizb.vars.id = rows[0].id;
          table.button("#dt_btn_stock_addition").enable();
          table.button("#dt_btn_stock_taking").enable();
          table.button("#dt_btn_history").enable();
          // console.log(rows[0])
        } else {
          table.button("#dt_btn_stock_addition").disable();
          table.button("#dt_btn_stock_taking").disable();
          table.button("#dt_btn_history").disable();
        }
        // else if (count_selc > 1) {
        //     var rows = $hizb.dt.select.data();
        // }else{
        //     $hizb.vars.id = null;
        //     $hizb.vars.ids = null;
        // }

        // var text = $hizb.vars.crud;
        // var tab = $hizb.vars.nav_tab;
        // // var nav_tab_id = localStorage.getItem('nav_tab_id');
        // var nav_tab_id = $hizb.vars.nav_tab_id;
        // if (text != '' || text != 0 || text != null) {
        //     var crud = text.split(",");
        // }else{
        //     var crud = '';
        // }

        // if (crud) {
        //     if (crud[0] == 1) {
        //         table.button('#dt_btn_new').enable();
        //     }

        //     if (crud[2] == 1) {
        //         if (count_selc == 1) {
        //             table.button('#dt_btn_edit').enable();
        //         }else if (count_selc > 1) {
        //             table.button('#dt_btn_edit').disable();
        //         }else{
        //             table.button('#dt_btn_edit').disable();
        //         }

        //         // if (action == 'edit') {
        //         //     $('.modal_btn_edit').prop('disabled', false);
        //         //     $('.modal_btn_save').prop('disabled', true);
        //         // }
        //     }

        //     if (crud[3] == 1) {
        //         if (count_selc > 0) {
        //             table.button('#dt_btn_delete').enable();
        //         }else{
        //             table.button('#dt_btn_delete').disable();
        //         }
        //     }

        //     if ($hizb.vars.module_kode == '') {
        //         if (nav_tab_id == 'nav-released-tab') {
        //             if ($hizb.dt.select.count() > 0) {
        //                 // table.button('#dt_btn_new').disable();
        //                 // table.button('#dt_btn_edit').disable();
        //                 table.button('#dt_btn_approve').enable();
        //                 table.button('#dt_btn_reject').enable();
        //                 table.button('#dt_btn_delete').enable();
        //             }

        //             // if (crud[2] == 1) {
        //             //     $hizb.dt.button.edit();
        //             // }

        //             // if ($hizb.dt.select.count() == 1) {
        //             //     table.button('#dt_btn_edit').enable();
        //             // }else{
        //             //     table.button('#dt_btn_edit').disable();
        //             // }
        //             // console.log('nav-release-tab');
        //         }

        //         // if (tab == 1) {
        //         //     /**
        //         //      * pada tab Released List, dokument tidak bisa dilakukan Edit, Release dan Delete */
        //         //     if (crud[4] == 1) {
        //         //         if ($hizb.dt.select.count() > 0) {
        //         //             table.button('#dt_btn_approve').enable();
        //         //             table.button('#dt_btn_reject').enable();
        //         //         }
        //         //     }
        //         // }

        //         // if (crud[2] == 1) {
        //         //     if (count_selc == 1) {
        //         //         table.button('#dt_btn_edit').enable();
        //         //     }else if (count_selc > 1) {
        //         //         table.button('#dt_btn_edit').disable();
        //         //     }else{
        //         //         table.button('#dt_btn_edit').disable();
        //         //     }

        //         //     if (action == 'edit') {
        //         //         $('.modal_btn_edit').prop('disabled', false);
        //         //         $('.modal_btn_save').prop('disabled', true);
        //         //     }
        //         // }else{
        //         //     table.button('#dt_btn_edit').disable();
        //         // }
        //     }

        //     if ($hizb.vars.module_kode == 'she_hazard_report') {
        //         table.button('#dt_btn_new').enable();
        //         table.button('#dt_btn_edit').disable();
        //         table.button('#dt_btn_release').disable();
        //         table.button('#dt_btn_delete').disable();
        //         table.button('#dt_btn_approve').disable();
        //         table.button('#dt_btn_pending').disable();
        //         table.button('#dt_btn_reject').disable();

        //             // console.log(crud);
        //             // console.log(crud);
        //             // console.log(count_selc);

        //             // c,rall,u,d,admin
        //             // 0,1   ,2,3,4

        //             // if (crud) {
        //             //     if (crud[0] == 1) {
        //             //         if (count_selc == 1) {
        //             //             table.button('#btn_new').disable();
        //             //             table.button('#dt_btn_new').disable();
        //             //         }else if (count_selc > 1) {
        //             //             table.button('#btn_new').disable();
        //             //             table.button('#dt_btn_new').disable();
        //             //         }else{
        //             //             table.button('#btn_new').enable();
        //             //             table.button('#dt_btn_new').enable();
        //             //         }

        //             //         if (action == 'new') {
        //             //             $('.modal_btn_edit').prop('disabled', true);
        //             //             $('.modal_btn_save').prop('disabled', false);
        //             //         }
        //             //     }else{
        //             //         table.button('#btn_new').disable();
        //             //         table.button('#dt_btn_new').disable();
        //             //     }

        //             //     if (crud[2] == 1) {
        //             //         if (count_selc == 1) {
        //             //             table.button('#dt_btn_edit').enable();
        //             //         }else if (count_selc > 1) {
        //             //             table.button('#dt_btn_edit').disable();
        //             //         }else{
        //             //             table.button('#dt_btn_edit').disable();
        //             //         }

        //             //         if (action == 'edit') {
        //             //             $('.modal_btn_edit').prop('disabled', false);
        //             //             $('.modal_btn_save').prop('disabled', true);
        //             //         }
        //             //     }else{
        //             //         table.button('#dt_btn_edit').disable();
        //             //     }

        //             //     if (crud[3] == 1) {
        //             //         if (count_selc > 0) {
        //             //             table.button('#dt_btn_delete').enable();
        //             //         }else{
        //             //             table.button('#dt_btn_delete').disable();
        //             //         }
        //             //     }else{
        //             //         table.button('#dt_btn_delete').disable();
        //             //     }
        //             // }else{
        //             //     table.button('#dt_btn_new').enable();
        //             //     table.button('#dt_btn_edit').disable();
        //             //     table.button('#dt_btn_delete').disable();
        //             // }

        //             // if ($hizb.vars.module_kode == 'event_recruitment') {
        //             //     if (count_selc == 1) {
        //             //         table.button('#dt_btn_open_recruitment').enable();
        //             //     }else{
        //             //         table.button('#dt_btn_open_recruitment').disable();
        //             //     }
        //             // }

        //             // if ($hizb.vars.module_kode == 'she_hazard_report') {
        //             //     if (count_selc >= 1) {
        //             //         table.button('#btn_release').enable();
        //             //     }else{
        //             //         table.button('#btn_release').disable();
        //             //     }
        //             // }

        //             // table.button('#btn_edit').disable();
        //             // table.button('#btn_approve').disable();
        //             // table.button('#btn_reject').disable();
        //             // table.button('#btn_release').disable();
        //             // table.button('#btn_multi_delete').disable();

        //             /**
        //              * crud[0] = create
        //              * crud[1] = read all
        //              * crud[2] = update
        //              * crud[3] = delete
        //              * crud[4] = admin*/

        //             /**
        //              * jika tab Not Release atau Rejected List active */
        //         if (nav_tab_id == 'nav-notrelease-tab' || nav_tab_id == 'nav-rejected-tab' ) {
        //             if ($hizb.dt.select.count() > 0) {
        //                 table.button('#dt_btn_release').enable();

        //                 if (crud[3] == 1) {
        //                     table.button('#dt_btn_delete').enable();
        //                 }

        //             }

        //             // if (crud[2] == 1) {
        //             //     $hizb.dt.button.edit();
        //             // }

        //             // if ($hizb.dt.select.count() == 1) {
        //             //     table.button('#dt_btn_edit').enable();
        //             // }else{
        //             //     table.button('#dt_btn_edit').disable();
        //             // }
        //         }

        //             /**
        //              * Jika tab Released List active */
        //         if (nav_tab_id == 'nav-released-tab') {
        //                 /**
        //                  * pada tab Released List, dokument tidak bisa dilakukan Edit, Release dan Delete */
        //             if (crud[4] == 1) {
        //                 if ($hizb.dt.select.count() > 0) {
        //                     table.button('#dt_btn_approve').enable();
        //                     table.button('#dt_btn_reject').enable();
        //                 }
        //             }
        //         }

        //             // if (crud[2] == 1) {
        //             //     if (count_selc == 1) {
        //             //         table.button('#dt_btn_edit').enable();
        //             //     }else if (count_selc > 1) {
        //             //         table.button('#dt_btn_edit').disable();
        //             //     }else{
        //             //         table.button('#dt_btn_edit').disable();
        //             //     }

        //             //     if (action == 'edit') {
        //             //         $('.modal_btn_edit').prop('disabled', false);
        //             //         $('.modal_btn_save').prop('disabled', true);
        //             //     }
        //             // }else{
        //             //     table.button('#dt_btn_edit').disable();
        //             // }
        //     }

        //     if ($hizb.vars.module_kode == 'hcm_applicants') {
        //         table.button('#dt_btn_new').enable();
        //         table.button('#dt_btn_edit').disable();
        //         table.button('#dt_btn_release').disable();
        //         table.button('#dt_btn_delete').disable();
        //         table.button('#dt_btn_approve').disable();
        //         table.button('#dt_btn_pending').disable();
        //         table.button('#dt_btn_reject').disable();

        //         /**
        //          * crud[0] = create
        //          * crud[1] = read all
        //          * crud[2] = update
        //          * crud[3] = delete
        //          * crud[4] = admin*/
        //         /**

        //         /**
        //          * Jika tab Released List active */
        //         if (nav_tab_id == null || nav_tab_id == '' || nav_tab_id == 'nav-released-tab') {
        //             /**
        //              * pada tab Released List, dokument bisa diapprove dan direject */
        //             if (crud[4] == 1) {
        //                 if ($hizb.dt.select.count() > 0) {
        //                     table.button('#dt_btn_approve').enable();
        //                     table.button('#dt_btn_reject').enable();
        //                 }
        //             }
        //         }
        //     }
        // }
      },
    },

    after_cud: function () {
      $hizb.views.button.dt.showhide1();
      $("#text_loader").html("");
    },

    var_id: function () {
      var count_selc = $hizb.dt.select.count();

      if (count_selc == 1) {
        var rows = $hizb.dt.select.data();
        $hizb.vars.id = rows[0].id;
        $hizb.vars.ids = null;

        // console.log('sama dengan 1');
      }

      if (count_selc > 1) {
        var rows = $hizb.dt.select.data();
        $hizb.vars.id = null;

        // console.log('lebih dari 1');
      }

      if (count_selc == 0) {
        $hizb.vars.id = null;
        $hizb.vars.ids = null;

        // console.log('tidak ada yg terpilih');
      }
    },

    layout: {
      button: function (btn) {
        table.button().add(0, {
          extend: "pageLength",
          className: "py-1 dt-btn-ummu",
          attr: { id: "btn_page_length" },
        });

        table.button().add(1, {
          text:
          '<span class="d-none d-sm-block"><i class="fas fa-sync-alt"></i> Reload</span>' +
          '<span class="d-block d-sm-none"><i class="fas fa-sync-alt"></i></span>',
          attr: { id: "btn_reload" },
          className: "btn-showall-color py-1 dt-btn-ummu",
          action: function (e, dt, node, config) {
            table.ajax.reload(function () {
              $hizb.dt.button.crud();
              $hizb.dt.button.trx();
            });
          },
        });

        if (btn && btn.includes("btn_select_all") == true) {
          table.button().add(2, {
            extend: "selectAll",
            className: "py-1 dt-btn-ummu",
            attr: { id: "btn_select_all" },
            text:
            '<span class="d-none d-sm-block">Select all</span>' +
            '<span class="d-block d-sm-none"><i class="fas fa-check-square fa-lg"></i></span>',
          });
        }

        if (btn && btn.includes("btn_select_none") == true) {
          table.button().add(3, {
            extend: "selectNone",
            className: "py-1 dt-btn-ummu",
            attr: { id: "btn_select_none" },
            text:
            '<span class="d-none d-sm-block">Deselect all</span>' +
            '<span class="d-block d-sm-none"><i class="far fa-check-square fa-lg"></i></span>',
          });
        }

        table.button().add(4, {
          className: "py-1 dt-btn-ummu",
          attr: { id: "dt_btn_filter" },
          text:
          '<span class="d-none d-sm-block"><i class="far fa-filter"></i> Filter</span>' +
          '<span class="d-block d-sm-none"><i class="far fa-filter fa-lg"></i></span>',
          action: function (e, dt, node, config) {
            $("#modal_filter").modal("show");
          },
        });

        table.button().add(5, {
          extend: "copy",
          className: "py-1 dt-btn-ummu",
          attr: { id: "btn_copy" },
          text: '<i class="fas fa-copy fa-lg"></i>',
        });

        table.button().add(6, {
          extend: "csv",
          className: "py-1 dt-btn-ummu",
          attr: { id: "btn_csv" },
          text: '<i class="fas fa-file-csv text-info fa-lg"></i>',
        });

        table.button().add(7, {
          extend: "excel",
          className: "py-1 dt-btn-ummu",
          attr: { id: "btn_excel" },
          text: '<i class="fas fa-file-excel text-success fa-lg"></i>',
          exportOptions: {
            orthogonal: "myExport",
          },
        });

        table.button().add(8, {
          extend: "pdf",
          className: "py-1 dt-btn-ummu",
          attr: { id: "btn_pdf" },
          text: '<i class="fas fa-file-pdf text-danger fa-lg"></i>',
        });

        table.button().add(9, {
          extend: "print",
          className: "py-1 dt-btn-ummu",
          attr: { id: "btn_print" },
          text: '<i class="fas fa-print text-primary fa-lg"></i>',
        });
      },

      button_crud: function (crud) {
        if (crud) {
          if (crud.includes("new") == true) {
            table
            .button()
            .add(10, {
              text: '<i class="fas fa-plus text-primary"></i> New',
              attr: { id: "dt_btn_new" },
              className:
              "btn-showall-color hidden collapse py-1 dt-btn-ummu for-user",
              action: function (e, dt, node, config) {
                $hizb.vars.action = "new";
                app.controllers.new();
              },
            })
            .disable();
          }

          if (crud.includes("edit") == true) {
            table
            .button()
            .add(11, {
              text: '<i class="fas fa-edit"></i> Edit',
              attr: { id: "dt_btn_edit" },
              className:
              "btn-showall-color hidden collapse py-1 dt-btn-ummu for-user",
              action: function (e, dt, node, config) {
                var rows = $hizb.dt.select.data();
                $hizb.vars.row = rows[0];
                $hizb.vars.action = "edit";
                app.controllers.edit(rows[0]);
              },
            })
            .disable();
          }

          if (crud.includes("delete") == true) {
            table
            .button()
            .add(12, {
              text: '<i class="fas fa-trash-alt text-danger"></i> Delete',
              attr: { id: "dt_btn_delete" },
              className:
              "btn-showall-color hidden collapse py-1 dt-btn-ummu for-user",
              action: function (e, dt, node, config) {
                var rows = $hizb.dt.select.data();
                $hizb.vars.rows = rows;
                $hizb.vars.row = rows[0];
                $hizb.vars.action = "delete";
                $("#modal_delete_confirm").modal("show");
              },
            })
            .disable();
          }

          if (crud.includes("delete2") == true) {
            table
            .button()
            .add(12, {
              text: '<i class="fas fa-trash-alt text-danger"></i> Delete',
              attr: { id: "dt_btn_delete" },
              className:
              "btn-showall-color hidden collapse py-1 dt-btn-ummu for-user",
              action: function (e, dt, node, config) {
                var rows = $hizb.dt.select.data();
                $hizb.vars.rows = rows;
                $hizb.vars.row = rows[0];
                $hizb.vars.action = "delete2";
                app.controllers.delete(rows[0]);
              },
            })
            .disable();
          }

          if (crud.includes("import") == true) {
            table
            .button()
            .add(13, {
              text: '<i class="fas fa-file-excel text-success"></i> Import',
              attr: { id: "dt_btn_import" },
              className: "btn-showall-color hidden collapse py-1 dt-btn-ummuz for-userz",
              action: function (e, dt, node, config) {
                $hizb.vars.action = "import";
                app.controllers.import();
              },
            })
            .disable();
          }
        }
      },

      button_status: function (status) {
        if (status) {
          if (status.includes("release") == true) {
            table
            .button()
            .add(13, {
              text: '<i class="fas fa-share text-primary"></i> Release',
              attr: { id: "dt_btn_release" },
              className: "py-1 dt-btn-ummu for-user",
              action: function (e, dt, node, config) {
                var rows = $hizb.dt.select.data();
                $hizb.vars.rows = rows;
                $("#modal_release_confirm").modal("show");
              },
            })
            .disable();
          }

          if (status.includes("approve") == true) {
            table
            .button()
            .add(14, {
              text: '<i class="fas fa-check text-success"></i> Approve',
              attr: { id: "dt_btn_approve" },
              className: "py-1 dt-btn-ummu dt-action",
              action: function (e, dt, node, config) {
                var rows = $hizb.dt.select.data();
                $hizb.vars.rows = rows;
                $hizb.vars.is_row = false;
                $("#modal_approve_confirm").modal("show");
              },
            })
            .disable();
          }

          if (status.includes("pending") == true) {
            table
            .button()
            .add(15, {
              text: '<i class="fal fa-business-time text-warning"></i> Pending',
              attr: { id: "dt_btn_pending" },
              className: "py-1 dt-btn-ummu dt-action",
              action: function (e, dt, node, config) {
                var rows = $hizb.dt.select.data();
                $hizb.vars.rows = rows;
                $("#modal_pending_confirm").modal("show");
              },
            })
            .disable();
          }

          if (status.includes("reject") == true) {
            table
            .button()
            .add(16, {
              text: '<i class="fas fa-times text-danger"></i> Reject',
              attr: { id: "dt_btn_reject" },
              className: "py-1 dt-btn-ummu dt-action",
              action: function (e, dt, node, config) {
                var rows = $hizb.dt.select.data();
                $hizb.vars.rows = rows;
                $hizb.vars.is_row = false;
                $("#modal_reject_confirm").modal("show");
              },
            })
            .disable();
          }
        }
      },

      button_trx: function (trx) {
        if (trx) {
          if (trx.includes("add") == true) {
            table
            .button()
            .add(17, {
              text: '<i class="fas fa-file-plus text-primary"></i> Add',
              attr: { id: "dt_btn_add" },
              className: "py-1 dt-btn-ummu for-user",
              action: function (e, dt, node, config) {
                var rows = $hizb.dt.select.data();
                $hizb.vars.row = rows[0];
                $hizb.vars.action = "add";
                app.controllers.add(rows[0]);
              },
            })
            .disable();
          }

          if (trx.includes("stock_addition") == true) {
            table
            .button()
            .add(18, {
              text: '<i class="fal fa-folder-plus fa-lg text-primary"></i> Stock Addition',
              attr: { id: "dt_btn_stock_addition" },
              className: "py-1 dt-btn-ummu for-user",
              action: function (e, dt, node, config) {
                var rows = $hizb.dt.select.data();
                $hizb.vars.row = rows[0];
                $hizb.vars.action = "addition";
                app.controllers.stock_addition(rows[0]);
              },
            })
            .disable();
          }

          if (trx.includes("stock_taking") == true) {
            table
            .button()
            .add(19, {
              text: '<i class="fal fa-folder-minus fa-lg text-danger"></i> Stock Taking',
              attr: { id: "dt_btn_stock_taking" },
              className: "py-1 dt-btn-ummu for-user",
              action: function (e, dt, node, config) {
                var rows = $hizb.dt.select.data();
                $hizb.vars.row = rows[0];
                $hizb.vars.action = "taking";
                app.controllers.stock_taking(rows[0]);
              },
            })
            .disable();
          }

          if (trx.includes("history") == true) {
            table
            .button()
            .add(20, {
              text: '<i class="far fa-file-medical-alt fa-lg"></i> Hisotry',
              attr: { id: "dt_btn_history" },
              className: "py-1 dt-btn-ummu for-user",
              action: function (e, dt, node, config) {
                var rows = $hizb.dt.select.data();
                $hizb.vars.row = rows[0];
                $hizb.vars.action = "get";
                app.controllers.history(rows[0]);
              },
            })
            .disable();
          }

          // if (trx.includes('approve') == true) {
          //     table.button().add(14,
          //         { text: '<i class="fas fa-check text-success"></i> Approve',
          //         attr: { id: 'dt_btn_approve'},
          //         className: 'py-1 dt-btn-ummu dt-action',
          //             action: function (e, dt, node, config) {
          //                 var rows = $hizb.dt.select.data();
          //                 $hizb.vars.rows = rows;
          //                 $('#modal_approve_confirm').modal('show');
          //             }
          //         }
          //     ).disable();
          // }

          // if (trx.includes('pending') == true) {
          //     table.button().add(15,
          //         { text: '<i class="fal fa-business-time text-warning"></i> Pending',
          //         attr: { id: 'dt_btn_pending'},
          //         className: 'py-1 dt-btn-ummu dt-action',
          //             action: function (e, dt, node, config) {
          //                 var rows = $hizb.dt.select.data();
          //                 $hizb.vars.rows = rows;
          //                 $('#modal_pending_confirm').modal('show');
          //             }
          //         }
          //     ).disable();
          // }

          // if (trx.includes('reject') == true) {
          //     table.button().add(16,
          //         { text: '<i class="fas fa-times text-danger"></i> Reject',
          //         attr: { id: 'dt_btn_reject'},
          //         className: 'py-1 dt-btn-ummu dt-action',
          //             action: function (e, dt, node, config) {
          //                 var rows = $hizb.dt.select.data();
          //                 $hizb.vars.rows = rows;
          //                 $('#modal_reject_confirm').modal('show');
          //             }
          //         }
          //     ).disable();
          // }
        }
      },

      column: {
        //
      },
    },
  },

  localStorage: {
    approval: {
      sum: {
        create: function (data) {
          localStorage.itr_jOut = data.ITR.jOutstanding;
          localStorage.itr_jPend = data.ITR.jPending;
          localStorage.itr_jRej = data.ITR.jReject;

          localStorage.ur_jOut = data.UR.jOutstanding;
          localStorage.ur_jPend = data.UR.jPending;
          localStorage.ur_jRej = data.UR.jReject;

          localStorage.mr_jOut = data.MR.jOutstanding;
          localStorage.mr_jPend = data.MR.jPending;
          localStorage.mr_jRej = data.MR.jReject;

          localStorage.pr_jOut = data.PR.jOutstanding;
          localStorage.pr_jPend = data.PR.jPending;
          localStorage.pr_jRej = data.PR.jReject;

          localStorage.po_jOut = data.PO.jOutstanding;
          localStorage.po_jPend = data.PO.jPending;
          localStorage.po_jRej = data.PO.jReject;
        },
        show: function () {
          $("#info_itr #info_out span, #approval_itr span").html(
            localStorage.getItem("itr_jOut")
            );
          $("#info_itr #info_pend span").html(
            localStorage.getItem("itr_jPend")
            );
          $("#info_itr #info_rej span").html(localStorage.getItem("itr_jRej"));

          $("#info_ur #info_out span, #approval_ur span").html(
            localStorage.getItem("ur_jOut")
            );
          $("#info_ur #info_pend span").html(localStorage.getItem("ur_jPend"));
          $("#info_ur #info_rej span").html(localStorage.getItem("ur_jRej"));

          $("#info_mr #info_out span, #approval_mr span").html(
            localStorage.getItem("mr_jOut")
            );
          $("#info_mr #info_pend span").html(localStorage.getItem("mr_jPend"));
          $("#info_mr #info_rej span").html(localStorage.getItem("mr_jRej"));

          $("#info_pr #info_out span, #approval_pr span").html(
            localStorage.getItem("pr_jOut")
            );
          $("#info_pr #info_pend span").html(localStorage.getItem("pr_jPend"));
          $("#info_pr #info_rej span").html(localStorage.getItem("pr_jRej"));

          $("#info_po #info_out span, #approval_po span").html(
            localStorage.getItem("po_jOut")
            );
          $("#info_po #info_pend span").html(localStorage.getItem("po_jPend"));
          $("#info_po #info_rej span").html(localStorage.getItem("po_jRej"));
        },
      },
    },
    referensi: JSON.parse(localStorage.getItem("referensi")),
  },

  ls: {
    toggle_sidebar: function () {
      var a = localStorage.getItem("toggle_sidebar");
      if (a == 1) {
        localStorage.setItem("toggle_sidebar", 0);
      } else {
        localStorage.setItem("toggle_sidebar", 1);
      }
    },
  },

  cookie: {
    setCookie: function (cname, cvalue, exdays) {
      const d = new Date();
      d.setTime(d.getTime() + exdays * 24 * 60 * 60 * 1000);
      let expires = "expires=" + d.toUTCString();
      document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
    },

    getCookie: function (cname) {
      let name = cname + "=";
      let ca = document.cookie.split(";");
      for (let i = 0; i < ca.length; i++) {
        let c = ca[i];
        while (c.charAt(0) == " ") {
          c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
          return c.substring(name.length, c.length);
        }
      }
      return "";
    },

    checkCookie: function () {
      let user = getCookie("username");
      if (user != "") {
        alert("Welcome again " + user);
      } else {
        user = prompt("Please enter your name:", "");
        if (user != "" && user != null) {
          setCookie("username", user, 365);
        }
      }
    },
  },

  modal: {
    detele_confirm: function () {
      var html =
      '<div class="modal fade" id="modal_confirm_delete" tabindex="-1">' +
      '<div class="modal-dialog">' +
      '<div class="modal-content">' +
      '<div class="modal-header">' +
      '<h5 class="modal-title">Confirmation</h5>' +
      '<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>' +
      "</div>" +
      '<div class="collapse" id="loader_delete">' +
      '<div class="d-flex justify-content-center mt-2">' +
      '<div class="spinner-border text-danger" role="status">' +
      "</div>" +
      "</div>" +
      "</div>" +
      '<div class="modal-body">' +
      "Are you sure to delete this data?" +
      "</div>" +
      '<div class="modal-footer">' +
      '<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>' +
      '<a href="#" id="btn_delete" class="btn btn-danger" onclick="app.controllers.delete();">Delete</a>' +
      "</div>" +
      "</div>" +
      "</div>" +
      "</div>";

      $(".ummu-html").html(html);
    },
  },

  button: {
    btn_modal_form: function (crud) {
      $("#modal_form .modal-footer").html("");
      var btn_close =
      '<button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>';
      var btn_edit =
      '<button type="button" class="btn btn-sm btn-warning" id="modal_btn_edit"><i class="fas fa-edit"></i> Edit</button>';
      var btn_save =
      '<button type="button" class="btn btn-sm btn-primary modal-btn-save"><i class="fas fa-save"></i> Save changes</button>';

      if (crud) {
        if (crud.includes("close") == true) {
          $("#modal_form .modal-footer").append(btn_close);
        }

        if (crud.includes("save") == true) {
          $("#modal_form .modal-footer").append(btn_save);
        }

        if (crud.includes("edit") == true) {
          $("#modal_form .modal-footer").append(btn_edit);
        }
      }

      // <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
      // <button type="button" class="btn btn-sm btn-warning" id="modal_btn_edit"><i class="fas fa-edit"></i> Edit</button>
      // <button type="button" class="btn btn-sm btn-primary btn-save" disabled><i class="fas fa-save"></i> Save changes</button>
    },

    hazard_report: {
      modal_form: function (crud) {
        $("#modal_form .modal-footer").html("");
        var btn_back =
        '<button type="button" class="btn btn-sm btn-secondary btn-back" id="btn_back">' +
        '<i class="fas fa-chevron-left"></i> Back' +
        "</button>";

        var btn_edit =
        '<button type="button" class="btn btn-sm btn-primary btn-edit modal_btn_edit" id="modal_btn_edit">' +
        '<i class="fas fa-edit"></i> Edit' +
        "</button>";

        var approve =
        '<button type="button" class="btn btn-sm btn-primary btn-approve modal_btn_approve" id="modal_btn_approve">' +
        '<i class="fas fa-check"></i> Approve' +
        "</button>";

        var reject =
        '<button type="button" class="btn btn-sm btn-danger btn-approve modal_btn_reject" id="modal_btn_reject">' +
        '<i class="fas fa-times"></i> Reject' +
        "</button>";

        var save =
        '<button type="button" class="btn btn-sm btn-primary btn-save modal_btn_save" id="modal_btn_save">' +
        '<i class="fas fa-save"></i> Save Change' +
        "</button>";

        var update =
        '<button type="button" class="btn btn-sm btn-primary btn-save modal_btn_update" id="modal_btn_update">' +
        '<i class="fas fa-save"></i> Update Change' +
        "</button>";

        var cancel =
        '<button type="button" class="btn btn-sm btn-secondary btn-cancel modal_btn_cancel" id="modal_btn_cancel">' +
        '<i class="fas fa-undo"></i> Cancel' +
        "</button>";

        if (crud) {
          if (crud.includes("back") == true) {
            $("#modal_form .modal-footer").append(btn_back);
          }

          if (crud.includes("edit") == true) {
            $("#modal_form .modal-footer").append(btn_edit);
          }

          if (crud.includes("approve") == true) {
            $("#modal_form .modal-footer").append(approve);
          }

          if (crud.includes("reject") == true) {
            $("#modal_form .modal-footer").append(reject);
          }

          if (crud.includes("save") == true) {
            $("#modal_form .modal-footer").append(save);
          }

          if (crud.includes("update") == true) {
            $("#modal_form .modal-footer").append(update);
          }

          if (crud.includes("cancel") == true) {
            $("#modal_form .modal-footer").append(cancel);
          }
        }
      },
    },
  },
};

$(document).ready(function () {
  $hizb.register.apply();
});

function resdel() {
  $("#response_deleted").modal("show");
}

/**
 * GLOBAL VARIABLE
 * */
var $globalVar = {
  page: null,
  class: null,
  location_hash: null,
};

/**
 * GLOBAL FUNCTION
 * */
var $globFunc = {
  ch_message: function (message) {
    const text = '<i class="fas fa-info-circle"></i> ' + message + " . . .";
    $("#response_message").html(text).addClass("text-success msg_animation");
  },

  ch_message_modal: function (message) {
    const text = '<i class="fas fa-info-circle"></i> ' + message + " . . .";
    $("#response_message_modal")
    .html(text)
    .addClass("text-success msg_animation");
  },

  ch_message_modal_modal: function (message) {
    const text = '<i class="fas fa-info-circle"></i> ' + message + " . . .";
    $("#response_message_modal_modal")
    .removeClass()
    .html(text)
    .addClass("text-success msg_animation");
  },

  countDate: function (datetime1, datetime2) {
    var inDetik = new Date(datetime2) - new Date(datetime1);
    var inMenit = Math.floor(inDetik / 60000);
    var inJam = Math.floor(inMenit / 60);
    var inHari = Math.floor(inJam / 24);

    var menit = inMenit - inJam * 60;
    var jam = inJam - inHari * 24;

    var response = inHari + " days, " + jam + " hours, " + menit + " minutes";

    // console.log(jam)
    return response;
  },
  countDate2: function (datetime1, datetime2) {
    var inDetik = new Date(datetime2) - new Date(datetime1);
    var inMenit = Math.floor(inDetik / 60000);
    var inJam = Math.floor(inMenit / 60);
    var inHari = Math.floor(inJam / 24);

    var menit = inMenit - inJam * 60;
    var jam = inJam - inHari * 24;

    var response =
    inHari +
    " <span class='text-muted'>days</span>, " +
    jam +
    " <span class='text-muted'>hours</span>, " +
    menit +
    " <span class='text-muted'>minutes</span>";

    // console.log(jam)
    return response;
  },
  countDate3: function (datetime1, datetime2) {
    var inDetik = new Date(datetime2) - new Date(datetime1);
    var inMenit = Math.floor(inDetik / 60000);
    var inJam = Math.floor(inMenit / 60);
    var inHari = Math.floor(inJam / 24);

    var menit = inMenit - inJam * 60;
    var jam = inJam - inHari * 24;

    var response = inHari + " day, " + jam + " hour, " + menit + " minute";

    // console.log(jam)
    return response;
  },
  getIdSelections: function () {
    return $.map($table.bootstrapTable("getSelections"), function (row) {
      return row.id;
    });
  },
  set_value_to_option: function (rows, element_id, kode) {
    $("#" + element_id).empty();
    $("#" + element_id).append(
      "<option value='' selected disabled>Choose...</option>"
      );
    for (let index in rows) {
      if (kode == 1) {
        var text = rows[index].kode + " - " + rows[index].name;
      } else {
        var text = rows[index].name;
      }
      $("#" + element_id).append(
        "<option value='" + rows[index].id + "'>" + text + "</option>"
        );
    }
  },
  set_value_to_option2: function (rows, element_id, kode) {
    $("#" + element_id).empty();
    $("#" + element_id).append(
      "<option value='' selected disabled>Choose...</option>"
      );
    for (let index in rows) {
      if (kode == 1) {
        var text = rows[index].kode + " | " + rows[index].name;
      } else {
        var text = rows[index].name;
      }
      $("#" + element_id).append(
        "<option value='" + rows[index].id + "'>" + text + "</option>"
        );
    }
  },
  set_value_to_option3: function (params) {
    var rows = params.rows;
    var element_id = params.element_id;
    var kode = params.kode;
    // var data = params.data;

    $("#" + element_id).empty();
    $("#" + element_id).append(
      "<option value='' selected disabled>Choose...</option>"
      );
    for (let index in rows) {
      if (kode == 1) {
        var text = rows[index].kode + " - " + rows[index].name;
      } else {
        var text = rows[index].name;
      }
      $("#" + element_id).append(
        "<option value='" + rows[index].id + "'>" + text + "</option>"
        );
    }
  },
  date_ymd: function (data) {
    var d = new Date(data),
    month = "" + (d.getMonth() + 1),
    day = "" + d.getDate(),
    year = d.getFullYear();

    if (month.length < 2) month = "0" + month;
    if (day.length < 2) day = "0" + day;

    return [year, month, day].join("-");
  },
  img_ratio: function (element_id) {
    var aspectRatio =
    $("#" + element_id + " img").width() /
    $("#" + element_id + " img").height();

    if (aspectRatio > 1) {
      $("#" + element_id).addClass("circular--landscape");
    } else if (aspectRatio < 1) {
      $("#" + element_id).addClass("circular--portrait");
    } else {
      $("#" + element_id).addClass("circular--square");
    }
  },
  header_avatar_ratio: function (element_id) {
    var aspectRatio = $(element_id).width() / $(element_id).height();

    if (aspectRatio > 1) {
      $(element_id).addClass("circular--landscape-35");
    } else if (aspectRatio < 1) {
      $(element_id).addClass("circular--portrait-35");
    } else {
      $(element_id).addClass("circular--square-35");
    }
  },
  modal_fullscreen: function (element_id) {
    var el = $(element_id);
    var hasClass = el.hasClass("modal-fullscreen");
    // console.log(hasClass)

    if (hasClass == true) {
      el.removeClass("modal-fullscreen");
    } else {
      el.addClass("modal-fullscreen");
    }
  },
};

/**
 * GLOBAL HELPERS
 * */
var $globalHelper = {
  currency: {
    // format number to US dollar
    us: function (data) {
      let USDollar = new Intl.NumberFormat("en-US", {
        minimumFractionDigits: 2,
        // style: 'currency',
        // currency: ' ',
      });

      return USDollar.format(data);
    },

    // // format number to British pounds
    // let pounds = Intl.NumberFormat('en-GB', {
    //     style: 'currency',
    //     currency: 'GBP',
    // });

    // // format number to Indian rupee
    // let rupee = new Intl.NumberFormat('en-IN', {
    //     style: 'currency',
    //     currency: 'INR',
    // });

    // // format number to Euro
    // let euro = Intl.NumberFormat('en-DE', {
    //     style: 'currency',
    //     currency: 'EUR',
    // });
  },
};

/**
 * GLOBAL UPLOAD
 * */
var $globalUpload = {
  filename: null,
  randomname: null,
  input_id: null,
  image_id: null,
  ids: [],
  filenames: [],

  // /*findAll_berangkas: function() {
  //     // $.ajax({
  //     //     type: 'GET',
  //     //     url: $base_url + "admin/berangkas/findAll",
  //     //     dataType: 'JSON',
  //     //     contentType: false,
  //     //     processData: false,
  //     // }).done(function(result) {
  //     //     console.log(result.status)
  //     //     if (result.status == true) {
  //     //         var data = result.rows;
  //     //         $('#album_berangkas').empty();
  //     //         for(let index in data){
  //     //             var $id = data[index].id;
  //     //             var filename = data[index].filename;
  //     //             if(filename == ''){
  //     //                 var $filename = 'no_image.jpg';
  //     //             }else{
  //     //                 var $filename = filename;
  //     //             }
  //     //             var $element = '<div class="col">'+
  //     //                 '<div class="card shadow-sm">'+
  //     //                     '<img class="img-thumbnail" src="'+ $base_url +'uploads/'+ $filename + '" style="height:160px;">'+
  //     //                     '<div class="card-body">'+
  //     //                         '<div class="d-flex justify-content-between align-items-center pt-3">'+
  //     //                             '<button type="button" class="btn btn-sm btn-outline-danger" onclick="$globalUpload.hapus_file_berangkas('+$id+')">Hapus</button>'+
  //     //                             '<button type="button" class="btn btn-sm btn-outline-success pilih-berkas" data-name="'+$filename+'">Pilih</button>'+
  //     //                         '</div>'+
  //     //                     '</div>'+
  //     //                 '</div>'+
  //     //             '</div>';
  //     //             $('#album_berangkas').append($element);
  //     //         }
  //     //         $('.pilih-berkas').click(function(){
  //     //             var $data_name = $(this).data('name');
  //     //             $globalUpload.input_id.val($data_name)
  //     //             $('#modal_berangkas_file').modal('hide')
  //     //             $globalUpload.image_id.attr('src', $base_url + 'uploads/' + $data_name)
  //     //         })
  //     //     }else{

  //     //     }
  //     // }).fail(function() {
  //     //     // An error occurred
  //     // });;

  //     var params = {
  //             "type": "get",
  //             "action": "get",
  //             "data": {
  //                 "limit":0,
  //                 "offset":0,
  //                 "sort": "id",
  //                 "order": "desc",
  //                 "search": ""
  //             },
  //             "cache": true,
  //             "contentType": "application/json",
  //             "dataType": "json"
  //         };
  //         var url = $base_url+'/admin/berangkas/show';
  //         var ali = $globalAjax.ummay(url,params);
  //         ali.done(function(result) {
  //             var response = JSON.parse(result);
  //             $globFunc.ch_message_modal_modal(response.message);
  //             // console.log(response.message)
  //             // var params2 = {
  //             //     "rows": response.rows,
  //             //     "element_id": 'gedung',
  //             //     "kode": 1
  //             // };

  //             // // $globFunc.set_value_to_option(response.rows,'gedung',1)
  //             // // $globFunc.set_value_to_option3(params2)
  //             // app.Views.set_value_to_option_gedung(params2)

  //             var data = response.rows;
  //             $('#album_berangkas').empty();
  //             for(let index in data){
  //                 var $id = data[index].id;
  //                 var id = data[index].id;
  //                 var filename = data[index].filename;
  //                 var description = data[index].description;

  //                 if(filename == ''){
  //                     var $filename = 'no_image.jpg';
  //                 }else{
  //                     var $filename = filename;
  //                 }

  //                 if (description == '' || description == null) {
  //                     var description_ = filename;
  //                 }else{
  //                     var description_ = description;
  //                 }

  //                 // var $elementz = '<div class="col">'+
  //                 //     '<div class="card shadow-sm">'+
  //                 //         '<img class="img-thumbnail" src="'+ $base_url +'uploads/'+ $filename + '" style="height:160px;">'+
  //                 //         '<div class="card-body">'+
  //                 //             '<div class="d-flex justify-content-between align-items-center pt-3">'+
  //                 //                 '<button type="button" class="btn btn-sm btn-outline-danger" onclick="$globalUpload.hapus_file_berangkas('+$id+')"><i class="fas fa-trash"></i></button>'+
  //                 //                 '<button type="button" class="btn btn-sm btn-outline-success pilih-berkas" data-name="'+$filename+'">Pilih</button>'+
  //                 //                 '<input class="form-check-input dorbitt-checkbox" type="checkbox">'+
  //                 //             '</div>'+
  //                 //         '</div>'+
  //                 //     '</div>'+
  //                 // '</div>';

  //                 var $element = '<div class="cont-checkbox">'+
  //                     '<input type="checkbox" class="dorbitt_checkbox_image_berangkas" name="dorbitt_checkbox_image_berangkas" id="'+id+'" data-name="'+$filename+'" />'+
  //                     '<label for="'+id+'" class="lbl_berangkas">'+
  //                         '<img src="'+ $base_url +'uploads/'+ $filename + '?crop=0.781xw:0.739xh;0.109xw,0.0968xh&resize=480:*"/>'+
  //                         '<span class="cover-checkbox">'+
  //                             '<svg viewBox="0 0 12 10">'+
  //                                 '<polyline points="1.5 6 4.5 9 10.5 1"></polyline>'+
  //                             '</svg>'+
  //                         '</span>'+
  //                         '<div class="info">'+description_+'</div>'+
  //                     '</label>'+
  //                 '</div>';
  //                 $('#album_berangkas').append($element);
  //             }
  //             $('.pilih-berkas').click(function(){
  //                 var $data_name = $(this).data('name');
  //                 $globalUpload.input_id.val($data_name)
  //                 $('#modal_berangkas_file').modal('hide')
  //                 $globalUpload.image_id.attr('src', $base_url + 'uploads/' + $data_name)
  //             })
  //         }).fail(function() {
  //             // An error occurred
  //         });
  // },*/

  // show_gallery: function() {
  //     if ($globalVar.page == 'gallery') {
  //         var page = 'gallery/show';
  //     }else{
  //         var page = $globalVar.page+'/show_gallery';
  //     }
  //     var params = {
  //         "type": "get",
  //         "action": "get",
  //         "data": {
  //             "limit":0,
  //             "offset":0,
  //             "sort": "id",
  //             "order": "desc",
  //             "search": "",
  //             "created_by": true
  //         },
  //         "cache": true,
  //         "contentType": "application/json",
  //         "dataType": "json"
  //     };
  //     var url = $base_url+'/admin/'+page;
  //     var ali = $globalAjax.ummay(url,params);
  //     ali.done(function(result) {
  //         var response = JSON.parse(result);
  //         $globFunc.ch_message_modal_modal(response.message);
  //         var data = response.rows;
  //         $('#album_gallery').empty();
  //         for(let index in data){
  //             var $id = data[index].id;
  //             var id = data[index].id;
  //             var filename = data[index].filename;
  //             var description = data[index].description;

  //             if(filename == ''){
  //                 var $filename = 'no_image.jpg';
  //             }else{
  //                 var $filename = filename;
  //             }

  //             if (description == '' || description == null) {
  //                 var description_ = filename;
  //             }else{
  //                 var description_ = description;
  //             }

  //             var $element = '<div class="cont-checkbox">'+
  //                 '<input type="checkbox" class="dorbitt_checkbox_image_gallery" name="dorbitt_checkbox_image_gallery" id="'+id+'" data-name="'+$filename+'" />'+
  //                 '<label for="'+id+'" class="lbl_gallery">'+
  //                     '<img src="'+ $base_url +'uploads/'+ $filename + '?crop=0.781xw:0.739xh;0.109xw,0.0968xh&resize=480:*"/>'+
  //                     '<span class="cover-checkbox">'+
  //                         '<svg viewBox="0 0 12 10">'+
  //                             '<polyline points="1.5 6 4.5 9 10.5 1"></polyline>'+
  //                         '</svg>'+
  //                     '</span>'+
  //                     '<div class="info">'+description_+'</div>'+
  //                 '</label>'+
  //             '</div>';
  //             $('#album_gallery').append($element);
  //         }
  //         $('.pilih-berkas').click(function(){
  //             var $data_name = $(this).data('name');
  //             $globalUpload.input_id.val($data_name)
  //             $('#modal_gallery').modal('hide')
  //             $globalUpload.image_id.attr('src', $base_url + 'uploads/' + $data_name)
  //         })
  //     }).fail(function() {
  //         // An error occurred
  //     });
  // },

  // show_gallery2: function() {
  //     var page = 'gallery/show';
  //     var params = {
  //         "type": "get",
  //         "action": "get",
  //         "data": {
  //             "limit":0,
  //             "offset":0,
  //             "sort": "id",
  //             "order": "desc",
  //             "search": "",
  //             "created_by": true
  //         },
  //         "cache": true,
  //         "contentType": "application/json",
  //         "dataType": "json"
  //     };
  //     var url = $base_url+'/admin/'+page;
  //     var ali = $globalAjax.ummay(url,params);
  //     ali.done(function(result) {
  //         var response = JSON.parse(result);
  //         $globFunc.ch_message_modal_modal(response.message);
  //         var data = response.rows;
  //         $('#album_gallery').empty();
  //         for(let index in data){
  //             var $id = data[index].id;
  //             var id = data[index].id;
  //             var filename = data[index].filename;
  //             var description = data[index].description;

  //             if(filename == ''){
  //                 var $filename = 'no_image.jpg';
  //             }else{
  //                 var $filename = filename;
  //             }

  //             if (description == '' || description == null) {
  //                 var description_ = filename;
  //             }else{
  //                 var description_ = description;
  //             }

  //             var $element = '<div class="cont-checkbox">'+
  //                 '<input type="checkbox" class="dorbitt_checkbox_image_gallery" name="dorbitt_checkbox_image_gallery" id="'+id+'" data-name="'+$filename+'" />'+
  //                 '<label for="'+id+'" class="lbl_gallery">'+
  //                     '<img src="'+ $base_url +'uploads/'+ $filename + '?crop=0.781xw:0.739xh;0.109xw,0.0968xh&resize=480:*"/>'+
  //                     '<span class="cover-checkbox">'+
  //                         '<svg viewBox="0 0 12 10">'+
  //                             '<polyline points="1.5 6 4.5 9 10.5 1"></polyline>'+
  //                         '</svg>'+
  //                     '</span>'+
  //                     '<div class="info">'+description_+'</div>'+
  //                 '</label>'+
  //             '</div>';
  //             $('#album_gallery').append($element);
  //         }
  //         $('.pilih-berkas').click(function(){
  //             var $data_name = $(this).data('name');
  //             $globalUpload.input_id.val($data_name)
  //             $('#modal_gallery').modal('hide')
  //             $globalUpload.image_id.attr('src', $base_url + 'uploads/' + $data_name)
  //         })
  //     }).fail(function() {
  //         // An error occurred
  //     });
  // },

  // upload_file_gallery: function() {
  //     var formData = new FormData();
  //     formData.append('file_upload', $('#file_upload')[0].files[0]);
  //     $.ajax({
  //         "url": $base_url + 'admin/gallery/do_upload',
  //         "method": "POST",
  //         "timeout": 0,
  //         "processData": false,
  //         "mimeType": "multipart/form-data",
  //         "contentType": false,
  //         "data": formData,
  //         beforeSend: function(e) {
  //             $('#modal_loader_submit_file').show()
  //             if(e && e.overrideMimeType) {
  //                 e.overrideMimeType('application/jsoncharset=UTF-8')
  //             }
  //         },
  //         complete: function(){
  //             $('#modal_loader_submit_file').hide()
  //         }
  //     })
  //     .done(function(result) {
  //         var response = JSON.parse(result);
  //         // console.log(response)
  //         // console.log(response.status)
  //         if(response.status==true){
  //             // $globalUpload.randomname = response.name;
  //             var payload = JSON.stringify({
  //                 "body": {
  //                     "filename": response.name,
  //                     "description": $('#file_description').val()
  //                 }
  //             })
  //             $globalUpload.insert_file_gallery(payload);
  //         }else{
  //             $('#modal_alert_submit_file').addClass('bg-success');
  //             $('#modal_alert_submit_file').html(response.errors.file_upload).fadeIn().delay(10000).fadeOut();
  //         }
  //     }).fail(function() {
  //         // An error occurred
  //     });
  // },

  // insert_file_gallery: function(payload) {
  //     $.ajax({
  //         "url": $base_url + 'admin/gallery/create',
  //         "method": "POST",
  //         "timeout": 0,
  //         "processData": false,
  //         "mimeType": "multipart/form-data",
  //         "contentType": false,
  //         "data": payload,
  //         beforeSend: function(e) {
  //             $('#modal_loader_submit_file').show()
  //             if(e && e.overrideMimeType) {
  //                 e.overrideMimeType('application/jsoncharset=UTF-8')
  //             }
  //         },
  //         complete: function(){
  //             $('#modal_loader_submit_file').hide()
  //         },
  //         error: function (xhr, ajaxOptions, thrownError) {
  //             alert(xhr.responseText);
  //         }
  //     })
  //     .done(function(result) {
  //         // console.log(result)
  //         var response = JSON.parse(result);
  //         if (response.status==true) {
  //             $('#modal_alert_submit_file').addClass('bg-success');
  //             $('#modal_alert_submit_file').html('Upload sukses').fadeIn().delay(10000).fadeOut();
  //             $globalUpload.show_gallery();
  //             $('#upload_img_thumbnail').attr('src', $base_url + 'uploads/no_image.jpg');
  //             $('#file_upload, #file_description').val('');
  //         }else{
  //             // $('#message_alert').html("");
  //             // var errors = response.message;
  //             // for(let index in errors){
  //             //     $('#message_alert').append("<li>"+errors[index]+"</li>");
  //             // }
  //             // $('#message_modal').modal('show');
  //         }
  //         $globFunc.ch_message_modal_modal(response.message);
  //     }).fail(function() {
  //         // An error occurred
  //         console.log(create)
  //     });
  // },

  // hapus_file_gallery: function(id) {
  //     $.ajax({
  //         "url": $base_url + "admin/gallery/delete/" + id,
  //         "method": "DELETE",
  //         "timeout": 0,
  //         beforeSend: function(e) {
  //             $('#modal_loader_gallery').show()
  //             if(e && e.overrideMimeType) {
  //                 e.overrideMimeType('application/jsoncharset=UTF-8')
  //             }
  //         },
  //         complete: function(){
  //             $('#modal_loader_gallery').hide()
  //         },
  //         success: function(response){
  //             // console.log(response)
  //         },
  //         error: function (xhr, ajaxOptions, thrownError) {
  //             alert(xhr.responseText);
  //         }
  //     })
  //     .done(function(result) {
  //         var response = JSON.parse(result);
  //         console.log(response.status)
  //         if(response.status==true){
  //             $globalUpload.show_gallery();
  //         }
  //     }).fail(function() {
  //         // An error occurred
  //     });
  // }
};

/**
 * GLOBAL DATATABLES
 * */
var $datatable = {
  umma: function (url, payload) {
    var table = $("#dataTable").DataTable({
      ajax: "/test/0",
      processing: true,
      language: {
        loadingRecords: "&nbsp;",
        processing: '<div class="spinner"></div>',
      },
    });
  },

  config: function (col) {
    return {
      deferLoading: 57,
      processing: true,
      lengthMenu: [10, 50, 100, { label: "All", value: -1 }],
      select: true,
      layout: {
        topStart: {
          buttons: [
            "pageLength",
            {
              text: "Approve",
              action: function (e, dt, node, config) {
                alert("Button activated");
              },
            },
          ],
        },
      },
      columnDefs: [
        {
          orderable: false,
          render: DataTable.render.select(),
          targets: 0,
        },
      ],
      fixedColumns: {
        start: 2,
      },
      order: [[1, "asc"]],
      scrollCollapse: true,
      scrollX: true,
      scrollY: 300,
      select: {
        style: "multi",
        selector: "td:first-child",
      },
      columns: [
        { data: "" },
        {
          data: "doc_code",
          render: function (data, type) {
            return (
              '<a href="#">' +
              data +
              ' <i class="fas fa-external-link-alt ml-2"></i></a>'
              );
          },
        },
        {
          data: "doc_date",
          render: function (data, type) {
            // var d = new Date(data),
            //     month = '' + (d.getMonth() + 1),
            //     day = '' + d.getDate(),
            //     year = d.getFullYear();

            // if (month.length < 2)
            //     month = '0' + month;
            // if (day.length < 2)
            //     day = '0' + day;

            // return [year, month, day].join('-');
            return $globFunc.date_ymd(data);
          },
        },
        { data: "category" },
        { data: "CostCenterName" },
        { data: "receive_name" },
        { data: "aprove_name" },
        { data: "doc_remark" },
      ],
    };
  },
};

/**
 * GLOBAL AJAX
 * */
var $globalAjax = {
  ummu: function (url, payload) {
    // console.log(payload);
    var jqXHR = $.ajax({
      url: url,
      method: payload.type,
      timeout: 0,
      headers: {
        "Content-Type": payload.contentType,
      },
      data: payload.data,
      prossesing: true,
      language: {
        loadingRecords: "&nbsp;",
        processing: '<div class="spinner"></div>',
      },
      beforeSend: function (e) {
        // if (payload.type == 'delete') {
        //     $('#loader_delete').show()
        // }else{
        //     $('#modal_loader_input').show()
        // }

        if (payload.action == "delete") {
          $("#loader_delete").show();
        } else if (payload.action == "multiple_delete") {
          $("#loader_mulitple_delete").show();
        } else if (payload.action == "insert" || payload.action == "update") {
          $("#modal_loader_input").show();
        }

        if (e && e.overrideMimeType) {
          e.overrideMimeType("application/jsoncharset=UTF-8");
        }
        $(
          "#response_message, #response_message_modal, #response_message_modal_modal"
          ).removeClass("text-success msg_animation");
      },
      complete: function () {
        if (payload.action == "delete") {
          $("#loader_delete").hide();
        } else if (payload.action == "multiple_delete") {
          $("#loader_mulitple_delete").hide();
        } else if (payload.action == "insert" || payload.action == "update") {
          $("#modal_loader_input").hide();
        }
        // $('#loader_delete').hide()
        // $('#loader_mulitple_delete').hide()
        // $('#modal_loader_input').hide()
      },
      success: function (response) {
        // console.log(response)
      },
      error: function (xhr, ajaxOptions, thrownError) {
        alert(xhr.responseText);
      },
    });

    return jqXHR;
  },

  ummay: function (url, payload) {
    // console.log(payload);
    var jqXHR = $.ajax({
      url: url,
      method: payload.type,
      timeout: 0,
      headers: {
        "Content-Type": payload.contentType,
      },
      data: payload.data,
      beforeSend: function (e) {
        if (payload.action == "delete") {
          $("#loader_delete").show();
        } else if (payload.action == "multiple_delete") {
          $("#loader_mulitple_delete").show();
        } else if (payload.action == "insert" || payload.action == "update") {
          $("#modal_loader_input").show();
        }

        if (e && e.overrideMimeType) {
          e.overrideMimeType("application/jsoncharset=UTF-8");
        }
        // $('#response_message').removeClass('text-success msg_animation');
      },
      complete: function () {
        if (payload.action == "delete") {
          $("#loader_delete").hide();
        } else if (payload.action == "multiple_delete") {
          $("#loader_mulitple_delete").hide();
        } else if (payload.action == "insert" || payload.action == "update") {
          $("#modal_loader_input").hide();
        }
      },
      success: function (response) {
        // console.log(response)
      },
      error: function (xhr, ajaxOptions, thrownError) {
        alert(xhr.responseText);
      },
    });

    return jqXHR;
  },

  show: function (url, payload) {
    console.log(payload);
    // var data = params.data;
    // // console.log(data)

    // if (data.sort) {
    //     var sort = data.sort;
    // }else{
    //     var sort = "id"
    // }

    // if (data.order) {
    //     var order = data.order;
    // }else{
    //     var order = "desc"
    // }

    // var jqXHR = $.ajax({
    //     "url": url + "?limit=" + data.limit + "&offset=" + data.offset + "&sort=" + sort + "&order=" + order + "&search=" + data.search,
    //     "method": "GET",
    //     "timeout": 0,
    // });

    // return jqXHR;

    var jqXHR = $.ajax({
      url: url,
      method: payload.type,
      timeout: 0,
      headers: {
        "Content-Type": payload.contentType,
      },
      data: payload.data,
      beforeSend: function (e) {
        $("#modal_loader_input").show();
        if (e && e.overrideMimeType) {
          e.overrideMimeType("application/jsoncharset=UTF-8");
        }
        // $('#response_message').html('');
        $("#response_message").removeClass("text-success msg_animation");
      },
      complete: function () {
        $("#modal_loader_input").hide();
      },
      success: function (response) {
        // console.log(response)
      },
      error: function (xhr, ajaxOptions, thrownError) {
        alert(xhr.responseText);
      },
    });

    return jqXHR;
  },

  findAll: function (params, url) {
    var data = params.data;
    // console.log(data)

    if (data.sort) {
      var sort = data.sort;
    } else {
      var sort = "id";
    }

    if (data.order) {
      var order = data.order;
    } else {
      var order = "desc";
    }

    var jqXHR = $.ajax({
      url:
      $base_url +
      url +
      "/findAll?limit=" +
      data.limit +
      "&offset=" +
      data.offset +
      "&sort=" +
      sort +
      "&order=" +
      order +
      "&search=" +
      data.search,
      method: "GET",
      timeout: 0,
    });

    return jqXHR;
  },

  save: function (url, method, payload) {
    console.log(payload);
    // var jqXHR = $.ajax({
    //     "url": url,
    //     "method": method,
    //     "timeout": 0,
    //     "headers": {
    //         "Content-Type": "application/json",
    //     },
    //     "data": payload,
    //     beforeSend: function(e) {
    //         $('#modal_loader_input').show()
    //         if(e && e.overrideMimeType) {
    //             e.overrideMimeType('application/jsoncharset=UTF-8')
    //         }
    //         $('#response_message').html('');
    //         $('#response_message').removeClass('text-success msg_animation');
    //     },
    //     complete: function(){
    //         $('#modal_loader_input').hide()
    //     },
    //     success: function(response){
    //         // console.log(response)
    //     },
    //     error: function (xhr, ajaxOptions, thrownError) {
    //         alert(xhr.responseText);
    //     }
    // });

    // return jqXHR;
  },

  create: function (url, payload) {
    var jqXHR = $.ajax({
      url: url,
      method: "POST",
      timeout: 0,
      headers: {
        "Content-Type": "application/json",
      },
      data: payload,
      beforeSend: function (e) {
        $("#modal_loader_input").show();
        if (e && e.overrideMimeType) {
          e.overrideMimeType("application/jsoncharset=UTF-8");
        }
        $("#response_message").html("");
        $("#response_message").removeClass("text-success msg_animation");
      },
      complete: function () {
        $("#modal_loader_input").hide();
      },
      success: function (response) {
        // console.log(response)
      },
      error: function (xhr, ajaxOptions, thrownError) {
        alert(xhr.responseText);
      },
    });

    return jqXHR;
  },

  update: function (url, payload) {
    var jqXHR = $.ajax({
      url: url,
      method: "PUT",
      timeout: 0,
      headers: {
        "Content-Type": "application/json",
      },
      data: payload,
      beforeSend: function (e) {
        $("#modal_loader_input").show();
        if (e && e.overrideMimeType) {
          e.overrideMimeType("application/jsoncharset=UTF-8");
        }
        $("#response_message").html("");
        $("#response_message").removeClass("text-success msg_animation");
      },
      complete: function () {
        $("#modal_loader_input").hide();
      },
      success: function (response) {
        // console.log(response)
      },
      error: function (xhr, ajaxOptions, thrownError) {
        alert(xhr.responseText);
      },
    });

    return jqXHR;
  },

  delete: function (url, params) {},

  wilayahIndonesia: {
    getRegencies: function (provincie_id, auto_slected) {
      $.ajax({
        type: "GET",
        url:
        $base_url +
        "admin/referensi/wilayah_indonesia/regencies/" +
        provincie_id,
        dataType: "JSON",
        contentType: false,
        processData: false,
      })
      .done(function (result) {
        var data = result;
        console.log(data);
        for (let index in data) {
          if (data[index].id == auto_slected) {
            var selected_auto = "selected";
          } else {
            var selected_auto = "";
          }
          $("#regencies").append(
            "<option value='" +
            data[index].id +
            "'" +
            selected_auto +
            " >" +
            data[index].name +
            "</option>"
            );
        }
        $("#regencies").attr("disabled", false);

        $("#regencies").select2({
          dropdownParent: $("#InsertModal"),
          theme: "bootstrap4",
        });
      })
      .fail(function () {
          // An error occurred
      });
    },

    getDistricts: function (regencie_id, auto_slected) {
      $.ajax({
        type: "GET",
        url:
        $base_url +
        "admin/referensi/wilayah_indonesia/districts/" +
        regencie_id,
        dataType: "JSON",
        contentType: false,
        processData: false,
      })
      .done(function (result) {
        var data = result;
        console.log(data);
        for (let index in data) {
          if (data[index].id == auto_slected) {
            var selected_auto = "selected";
          } else {
            var selected_auto = "";
          }
          $("#districts").append(
            "<option value='" +
            data[index].id +
            "'" +
            selected_auto +
            ">" +
            data[index].name +
            "</option>"
            );
        }
        $("#districts").attr("disabled", false);

        $("#districts").select2({
          dropdownParent: $("#InsertModal"),
          theme: "bootstrap4",
        });
      })
      .fail(function () {
          // An error occurred
      });
    },

    getVillages: function (district_id, auto_slected) {
      $.ajax({
        type: "GET",
        url:
        $base_url +
        "admin/referensi/wilayah_indonesia/villages/" +
        district_id,
        dataType: "JSON",
        contentType: false,
        processData: false,
      })
      .done(function (result) {
        var data = result;
        console.log(data);
        for (let index in data) {
          if (data[index].id == auto_slected) {
            var selected_auto = "selected";
          } else {
            var selected_auto = "";
          }
          $("#villages").append(
            "<option value='" +
            data[index].id +
            "'" +
            selected_auto +
            ">" +
            data[index].name +
            "</option>"
            );
        }
        $("#villages").attr("disabled", false);

        $("#villages").select2({
          dropdownParent: $("#InsertModal"),
          theme: "bootstrap4",
        });
      })
      .fail(function () {
          // An error occurred
      });
    },
  },

  masterData: {},

  getRefStatusMahasiswa: function () {
    var jqXHR = $.ajax({
      type: "GET",
      url: $base_url + "admin/referensi/get_ref_status_mahasiswa/",
      dataType: "JSON",
      contentType: false,
      processData: false,
    });

    return jqXHR;
  },

  getRefJenisTinggal: function () {
    var jqXHR = $.ajax({
      type: "GET",
      url: $base_url + "admin/referensi/jenis_tinggal/",
      dataType: "JSON",
      contentType: false,
      processData: false,
    });

    return jqXHR;
  },

  getRefAlatTransportasi: function () {
    var jqXHR = $.ajax({
      type: "GET",
      url: $base_url + "admin/referensi/alat_transportasi/",
      dataType: "JSON",
      contentType: false,
      processData: false,
    });

    return jqXHR;
  },

  getRefPekerjaan: function () {
    var jqXHR = $.ajax({
      type: "GET",
      url: $base_url + "admin/referensi/pekerjaan/",
      dataType: "JSON",
      contentType: false,
      processData: false,
    });

    return jqXHR;
  },

  getRefPenghasilan: function () {
    var jqXHR = $.ajax({
      type: "GET",
      url: $base_url + "admin/referensi/penghasilan/",
      dataType: "JSON",
      contentType: false,
      processData: false,
    });

    return jqXHR;
  },

  getRefPendidikan: function () {
    var jqXHR = $.ajax({
      type: "GET",
      url: $base_url + "admin/referensi/pendidikan/",
      dataType: "JSON",
      contentType: false,
      processData: false,
    });

    return jqXHR;
  },

  getProdi: function () {
    var jqXHR = $.ajax({
      type: "GET",
      url:
      $base_url +
      "admin/prodi/findAll?limit=10&offset=0&sort=id&order=desc&search=",
      dataType: "JSON",
      contentType: false,
      processData: false,
    });

    return jqXHR;
  },
};

/**
 * GLOBAL REFERENCES
 * */
var $globalRef = {
  getAll: function () {
    $globalRef.getProvinces();
    $globalRef.getRefAgama();
    $globalRef.getRefStatusMahasiswa();
    $globalRef.getRefJenisTinggal();
    $globalRef.getRefAlatTransportasi();
    $globalRef.getRefPendidikan();
    $globalRef.getRefPekerjaan();
    $globalRef.getRefPenghasilan();
    $globalRef.getRoles();
  },

  getProvinces: function (selectedID = null) {
    var $data = $ref.provinces;
    // console.log(selectedID);
    $("#provinces").empty();
    if (selectedID === null) {
      $("#provinces").append(
        "<option value='' selected disabled>Choose...</option>"
        );
      for (let index in $data) {
        $("#provinces").append(
          "<option value='" +
          $data[index].id +
          "'>" +
          $data[index].name +
          "</option>"
          );
      }
    } else {
      $("#provinces").append("<option value='' disabled>Choose...</option>");
      for (let index in $data) {
        $("#provinces").append(
          "<option value='" +
          $data[index].id +
          "'" +
          selectedID +
          ">" +
          $data[index].name +
          "</option>"
          );
      }
    }
    $("#provinces").select2({
      dropdownParent: $("#InsertModal"),
      theme: "bootstrap4",
      // placeholder: "Buscar y Selecionar",
      // width: 'auto',
      // dropdownAutoWidth: true,
      // allowClear: true,
    });
  },

  getRefAgama: function () {
    var $referensi = localStorage.getItem("referensi");
    var $ref = JSON.parse($referensi);
    var $data = $ref.agama;

    $("#agama").empty();
    $("#agama").append("<option value='' selected disabled>Choose...</option>");
    for (let index in $data) {
      $("#agama").append(
        "<option value='" +
        $data[index].id +
        "'>" +
        $data[index].name +
        "</option>"
        );
    }
    $("#agama").select2({
      dropdownParent: $("#InsertModal"),
      theme: "bootstrap4",
    });
  },

  getRefStatusMahasiswa: function () {
    var $data = $ref.status_mhs;

    $("#status").empty();
    $("#status").append(
      "<option value='' selected disabled>Choose...</option>"
      );
    for (let index in $data) {
      $("#status").append(
        "<option value='" +
        $data[index].id +
        "'>" +
        $data[index].name +
        "</option>"
        );
    }
    // $("#status").select2({
    //     dropdownParent: $("#InsertModal"),
    //     theme: "bootstrap4"
    // });
  },

  getRefJenisTinggal: function () {
    var $data = $ref.jenis_tinggal;

    $("#jenis_tinggal").empty();
    $("#jenis_tinggal").append(
      "<option value='' selected disabled>Choose...</option>"
      );
    for (let index in $data) {
      $("#jenis_tinggal").append(
        "<option value='" +
        $data[index].id +
        "'>" +
        $data[index].name +
        "</option>"
        );
    }
    $("#jenis_tinggal").select2({
      dropdownParent: $("#InsertModal"),
      theme: "bootstrap4",
    });
  },

  getRefAlatTransportasi: function () {
    var $data = $ref.alat_transportasi;

    $("#alat_transportasi").empty();
    $("#alat_transportasi").append(
      "<option value='' selected disabled>Choose...</option>"
      );
    for (let index in $data) {
      $("#alat_transportasi").append(
        "<option value='" +
        $data[index].id +
        "'>" +
        $data[index].name +
        "</option>"
        );
    }
    $("#alat_transportasi").select2({
      dropdownParent: $("#InsertModal"),
      theme: "bootstrap4",
    });
  },

  getRefPendidikan: function () {
    var $data = $ref.tingkat_pendidikan;

    $("#pendidikan_ayah, #pendidikan_ibu, #pendidikan_wali").empty();
    $("#pendidikan_ayah, #pendidikan_ibu, #pendidikan_wali").append(
      "<option value='' selected disabled>Choose...</option>"
      );
    for (let index in $data) {
      $("#pendidikan_ayah, #pendidikan_ibu, #pendidikan_wali").append(
        "<option value='" +
        $data[index].id +
        "'>" +
        $data[index].name +
        "</option>"
        );
    }
    $("#pendidikan_ayah, #pendidikan_ibu, #pendidikan_wali").select2({
      dropdownParent: $("#InsertModal"),
      theme: "bootstrap4",
    });
  },

  getRefPekerjaan: function () {
    var $data = $ref.jenis_pekerjaan;

    $("#pekerjaan_ayah, #pekerjaan_ibu, #pekerjaan_wali").empty();
    $("#pekerjaan_ayah, #pekerjaan_ibu, #pekerjaan_wali").append(
      "<option value='' selected disabled>Choose...</option>"
      );
    for (let index in $data) {
      $("#pekerjaan_ayah, #pekerjaan_ibu, #pekerjaan_wali").append(
        "<option value='" +
        $data[index].id +
        "'>" +
        $data[index].name +
        "</option>"
        );
    }
    $("#pekerjaan_ayah, #pekerjaan_ibu, #pekerjaan_wali").select2({
      dropdownParent: $("#InsertModal"),
      theme: "bootstrap4",
    });
  },

  getRefPenghasilan: function () {
    var $data = $ref.penghasilan;

    $("#penghasilan_ayah, #penghasilan_ibu, #penghasilan_wali").empty();
    $("#penghasilan_ayah, #penghasilan_ibu, #penghasilan_wali").append(
      "<option value='' selected disabled>Choose...</option>"
      );
    for (let index in $data) {
      $("#penghasilan_ayah, #penghasilan_ibu, #penghasilan_wali").append(
        "<option value='" +
        $data[index].id +
        "'>" +
        $data[index].name +
        "</option>"
        );
    }
    // $("#penghasilan_ayah, #penghasilan_ibu, #penghasilan_wali").select2({
    //     dropdownParent: $("#InsertModal"),
    //     theme: "bootstrap4",
    // });
  },

  // getRoles: function(selectedID = null) {
  //     var $data = $ref.roles;
  //     // console.log(selectedID);
  //     $('#role').empty();
  //     if(selectedID === null){
  //         $('#role').append("<option value='' selected disabled>Choose...</option>");
  //         for(let index in $data){
  //             $('#role').append("<option value='"+$data[index].id+"'>"+$data[index].name+"</option>");
  //         }
  //     }else{
  //         $('#role').append("<option value='' disabled>Choose...</option>");
  //         for(let index in $data){
  //             $('#role').append("<option value='"+$data[index].id+"'"+selectedID+">"+$data[index].name+"</option>");
  //         }
  //     }
  // },
};

/**
 * GLOBAL FORMATTER
 * */
var $globalFormatter = {
  jenis_kelamin: function (id) {
    if (id == 0) {
      return "Perempuan";
    } else if (id == 1) {
      return "Laki-laki";
    } else {
      return "-";
    }
  },

  sesi_kelas: function (id) {
    if (id == 1) {
      return "Pagi";
    } else if (id == 2) {
      return "Malam";
    } else {
      return "-";
    }
  },

  status_mahasiswa: function (id) {
    if (id == 1) {
      return '<span class="badge bg-success">Active</span>';
    } else if (id == 2) {
      return '<span class="badge bg-warning">Cuti</span>';
    } else if (id == 3) {
      return '<span class="badge bg-danger">DO</span>';
    } else if (id == 4) {
      return '<span class="badge bg-secondary">Mengundurkan Diri</span>';
    } else if (id == 5) {
      return '<span class="badge bg-secondary">Pindah</span>';
    } else if (id == 6) {
      return '<span class="badge bg-secondary">Lulus</span>';
    } else {
      return "-";
    }
  },

  forntAwesome: function (data) {
    var icon = $("<textarea />").html(data).text();
    return icon;
  },

  avatar: function (name) {
    if (name) {
      var img =
      '<img class="img-thumbnail" src="' +
      $base_url +
      "uploads/" +
      name +
      '">';
    } else {
      var img = "";
    }
    return img;
  },

  active: function (id) {
    if (id) {
      return '<span class="badge bg-success">Active</span>';
    } else {
      return "-";
    }
  },

  moduleName: function (index, row) {
    if (row.is_parent == "on") {
      var html = "<strong>" + row.name + "</strong>";
    } else {
      var html = row.name;
    }
    return html;
  },

  latlng: function (index, row) {
    if (row.latitude) {
      var html =
      '<a href="http://maps.google.com/maps?q=' +
      row.latitude +
      "," +
      row.longitude +
      '&amp;t=m&amp;hl=en" target="_blank">' +
      row.latitude +
      "," +
      row.longitude +
      "</a>";
    } else {
      var html = "";
    }

    return html;
  },

  join_datetime: function (index, row) {},
};

/**
 * GLOBAL EVENTS
 * */
var $globalEvents = {
  onClick: {
    dorbittButton: function () {
      $("#btn_show_password").click(function () {
        var type = $("#password").attr("type");
        if (type == "password") {
          $("#btn_show_password").html('<i class="bi bi-eye-slash-fill"></i>');
          $("#password").attr("type", "text");
        } else {
          $("#btn_show_password").html('<i class="bi bi-eye-fill"></i>');
          $("#password").attr("type", "password");
        }
      });

      $("#message_modal_close").on("click", function () {
        $("#message_modal").modal("hide");
      });

      $("#btn_submit_file_upload").click(function () {
        var file = $("#file_upload").val();
        if (file != "") {
          $globalUpload.upload_file_gallery();
        } else {
          alert("Silahkan pilih file terlebih dahulu.");
        }
      });

      $("#btn_endis").click(function () {
        $("#password").val("");
        if ($("#password").is(":disabled")) {
          $("#password").removeAttr("disabled");
          $("#trash_icon").show();
          $("#pencil_icon").hide();
        } else {
          $("#password").attr("disabled", "disabled");
          $("#trash_icon").hide();
          $("#pencil_icon").show();
        }
      });

      $("#btn_modal_max").on("click", function () {
        var el = $("#modal_dialog");
        var hasClass = el.hasClass("modal-lg");
        // console.log(hasClass)

        if (hasClass == true) {
          el.removeClass("modal-lg");
          el.addClass("modal-fullscreen");
        } else {
          el.removeClass("modal-fullscreen");
          el.addClass("modal-lg");
        }
      });

      $("#dorbitt_open_gallery").click(function () {
        var dataImage = $(this).attr("data-image");
        $globalUpload.show_gallery();
        $("#modal_gallery").modal("show");
        // $globalUpload.input_id = input_id;
        // $globalUpload.image_id = image_id;
      });

      $("#dorbitt_open_gallery2").click(function () {
        var dataImage = $(this).attr("data-image");
        $globalUpload.show_gallery2();
        $("#modal_gallery").modal("show");
        // $globalUpload.input_id = input_id;
        // $globalUpload.image_id = image_id;
      });

      // $('#btn_select_file').click(function() {
      //     var ids = [];
      //     var filenames = [];
      //     $('.dorbitt_checkbox_image_gallery:checked').each(function() {
      //         var id = $(this).attr('id');
      //         var filename = $(this).data('name');

      //         ids.push(parseInt(id));
      //         filenames.push(filename)
      //         // console.log(filename)
      //     });

      //     $globalUpload.ids = ids;
      //     $globalUpload.filenames = filenames;

      //     // app.Views.set_gallery_selected_to_img(filenames)

      //     $('#modal_gallery').modal('hide');
      //     // console.log(ids)
      // })

      $("#dorbitt_tabs .nav-tabs .nav-link").click(function () {
        var urlhash = $(this).attr("data-bs-target");
        window.location.hash = urlhash;
        // console.log(urlhash)
        // document.cookie = urlhash;
        Cookies.set("urlhash", urlhash);
      });
    },
  },

  onChange: {
    dorbittCheckBox: function () {
      $(".dorbitt_checkbox").change(function () {
        var element_id = $(this).attr("id");
        if (this.checked) {
          eval("globalVars." + element_id + " = 1");
        } else {
          eval("globalVars." + element_id + " = 0");
        }
      });
    },

    dorbittInput: function () {
      $("#file_upload").change(function () {
        var $id = $("#upload_img_thumbnail");
        var $filename = $(this)[0].files[0].name;
        var reader = new FileReader();
        reader.onload = function (e) {
          $($id).attr("src", e.target.result);
          // alert(e.target.result)
          $globalUpload.filename = $filename;
        };
        reader.readAsDataURL($(this)[0].files[0]);
      });
    },

    dorbittRadio: function () {
      $(".dorbitt-header #rad_approve").on("change", function () {
        $globalViews.approval.status_detail(1);
      });

      $(".dorbitt-header #rad_pending").on("change", function () {
        $globalViews.approval.status_detail(3);
      });

      $(".dorbitt-header #rad_reject").on("change", function () {
        $globalViews.approval.status_detail(2);
      });
    },

    // rmChkDetApp: function() {
    //     // var radioApproveOnHeader = $('.dorbitt-detail .rad-approve, .dorbitt-detail .rad-pending, .dorbitt-detail .rad-reject');
    //     $('.dorbitt-detail .rad-approve').attr('checked', false);
    //     $('.dorbitt-detail .rad-pending').attr('checked', false);
    //     $('.dorbitt-detail .rad-reject').attr('checked', false);
    // }

    // selectOption: function() {
    //     $('#gedung').change(function() {
    //         var maxNum = $(this).find(':selected').attr('data-lantai');
    //         $('#lantai').val("");
    //         $('#lantai').attr('max',maxNum);
    //     });
    // }
  },

  location_hash: function () {
    var urlhash = window.location.hash;
    var urlhashc = Cookies.get("urlhash");

    if (urlhash == urlhashc) {
      $(".nav-tabs li .nav-link").removeClass("active");
      $("[data-bs-target='" + urlhash + "']").addClass("active");

      $(".tab-content .tab-pane").removeClass("active").removeClass("show");
      $(".tab-content " + urlhash)
      .addClass("active")
      .addClass("show");
    }
  },
};

/**
 * GLOBAL VIEWS
 * */
var $globalViews = {
  approval: {
    status_detail: function (status) {
      $(
        ".dorbitt-detail .rad-approve, .dorbitt-detail .rad-pending, .dorbitt-detail .rad-reject"
        ).prop("checked", false);
      $(
        ".dorbitt-detail .rad-approve, .dorbitt-detail .rad-pending, .dorbitt-detail .rad-reject"
        ).prop("disabled", false);

      if (status == 1) {
        //approve
        $(".dorbitt-detail .rad-approve").prop("checked", true);
        $(".dorbitt-detail .rad-pending").prop("disabled", true);
      }

      if (status == 2) {
        //reject
        $(".dorbitt-detail .rad-reject").prop("checked", true);
        $(".dorbitt-detail .rad-approve, .dorbitt-detail .rad-pending").prop(
          "disabled",
          true
          );
      }

      if (status == 3) {
        //pending
        $(".dorbitt-detail .rad-pending").prop("checked", true);
        $(".dorbitt-detail .rad-reject").prop("disabled", true);
      }
    },
    status_detail_on_load: function (status) {
      // $('.dorbitt-detail .rad-approve, .dorbitt-detail .rad-pending, .dorbitt-detail .rad-reject').prop('checked', false);
      $(
        ".dorbitt-detail .rad-approve, .dorbitt-detail .rad-pending, .dorbitt-detail .rad-reject"
        ).prop("disabled", false);

      if (status == 1) {
        //approve
        // $('.dorbitt-detail .rad-approve').prop('checked', true);
        $(".dorbitt-detail .rad-pending").prop("disabled", true);
      }

      if (status == 2) {
        //reject
        // $('.dorbitt-detail .rad-reject').prop('checked', true);
        $(".dorbitt-detail .rad-approve, .dorbitt-detail .rad-pending").prop(
          "disabled",
          true
          );
      }

      if (status == 3) {
        //pending
        // $('.dorbitt-detail .rad-pending').prop('checked', true);
        $(".dorbitt-detail .rad-reject").prop("disabled", true);
      }
    },
  },

  modal: {
    message: function () {
      var html =
      '<div class="modal fade" id="message_modal" tabindex="-1" style="z-index: 2000;">' +
      '<div class="modal-dialog">' +
      '<div class="modal-content">' +
      '<div class="modal-header bg-secondary">' +
      '<h5 class="modal-title text-light" id="message_title">Messages</h5>' +
      '<button type="button" class="btn-close bg-light" data-bs-dismiss="modal" aria-label="Close"></button>' +
      "</div>" +
      '<div class="alert" id="text_message"></div>' +
      "</div>" +
      "</div>" +
      "</div>";
    },
  },
};
