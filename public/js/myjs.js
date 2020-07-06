
$('#startDayBook').datepicker({
  todayHighlight: true,
  orientation: "bottom left",
  autoclose: true,
  format: 'dd/mm/yyyy',
  templates: {
    leftArrow: '<i class="ti-arrow-left"></i>',
    rightArrow: '<i class="ti-arrow-right"></i>'
  }
});
$('#endDateBook').datepicker({
 todayHighlight: true,
 orientation: "bottom left",
 autoclose: true,
 format: 'dd/mm/yyyy',
 templates: {
  leftArrow: '<i class="ti-arrow-left"></i>',
  rightArrow: '<i class="ti-arrow-right"></i>'
}
});
$('#startDateUser').datepicker({
 todayHighlight: true,
 orientation: "bottom left",
 autoclose: true,
 format: 'dd/mm/yyyy',
 templates: {
  leftArrow: '<i class="ti-arrow-left"></i>',
  rightArrow: '<i class="ti-arrow-right"></i>'
}
});
$('#endDateUser').datepicker({
 todayHighlight: true,
 orientation: "bottom left",
 autoclose: true,
 format: 'dd/mm/yyyy',
 templates: {
  leftArrow: '<i class="ti-arrow-left"></i>',
  rightArrow: '<i class="ti-arrow-right"></i>'
}
});



$(document).ready(function() {
  $.validator.addMethod(
    "number",
    function (value, element) {
      return this.optional(element) || /^[0-9-.()]{1,20}$/i.test(value);
    },
    'Trường này phải là số'
    );

  // $.validator.addMethod(
  //   "number1",
  //   function (value, element) {
  //     return this.optional(element) || /^[1-9-.()]{1,20}$/i.test(value);
  //   },
  //   'Số phải lớn hơn 0'
  //   );

  $.validator.addMethod(
    "email",
    function(value, element) {
     
      var re = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
            return this.optional(element) || re.test(value);
          },
          'Email này  không hợp lệ'
          );
  $.validator.addMethod(
    "required",
    function(value, element) {
      return ($.trim(value) != '');
    },
    'Không được bỏ trống!'
    );
  $.validator.addMethod("valueNotEquals", function(value, element, arg){
    // I use element.value instead value here, value parameter was always null
    return arg != element.value; 
  }, "Giáo viên không được để trông.");
  $.validator.addMethod(
    "textname",
    function(value, element) {
      var re = new RegExp(/^[A-Za-z0-9]+$/);
            //var re = new RegExp(/^[ァ-ンｧ-ﾝﾞﾟー ]*$/);
            return this.optional(element) || re.test(value);
          },
          'Không được chứa ký tự đặc biệt'
          );


        //Khi bàn phím được nhấn và thả ra thì sẽ chạy phương thức này
        $("#create_user").validate({
          rules: {
           username: {
            required: true,
            textname:true
          },
          fullname: {
            required: true,
          },
          phone: {
            required: true,
            minlength: 10,
            maxlength:10,
            number:true,

          },
          email: {
            required: true,
            email: true
          },
          address: {
            required: true,
          },
          department: {
            required: true,
          },
          password: {
            required: true,
            minlength: 6,
            maxlength: 15,
            

          },
        },
        messages: {
          username: {
           required: "Mã nhân viên không được để trống",
         },
         fullname: {
           required: "Tên nhân viên không được để trống",
         },
         phone: {
           required: "Số điện thoại không được để trống",
           number : "Số điện thoại phải là số lớn hơn 0",
           minlength: "Số điện thoại không đúng",
         },
         email: {
           required: "Email không được để trống",
           email:"Email không đúng định dạng"
         },
         address: {
           required: "Địa chỉ không được để trống",
         },
         department: {
           required: "Phòng làm việc không được để trống",
         },
         password: {
           required: "Mật khẩu không được để trống",
           minlength: "Mật khẩu tối thiểu 6 kí tự",
         },


       },
        submitHandler: function(form) {
          
                let geturuser = $('#uservalidate').attr('getdatauser');
                let checkvalidateuser =  $('#uservalidate').val();
                let checkvalidateemail=  $('#emailuser').val();
                $.ajax({
                    "type": "POST",
                    "url": geturuser,
                    "data": {
                              username:checkvalidateuser,
                              email:checkvalidateemail
                            },
                    "success": function (data) {
                      let job = JSON.parse(data);
                        if (job.user == true) {
                            $('#uservalidate').parent().append('<label id="name-error" class="error" for="name">Mã Nhân viên đã tồn tại</label>');
                            $('#uservalidate').focus();
                        }else if (job.email ==  true) {
                          $('#emailuser').parent().append('<label id="name-error" class="error" for="name">Email đã tồn tại</label>');
                          $('#emailuser').focus();
                        } 
                        else {
                          form.submit();
                        }
                    }
                });
                // return false;
            // })
        },

     });
        $("#edit_user").validate({
         rules: {
           username: {
            required: true,
          },
          fullname: {
            required: true,
          },
          phone: {
            required: true,
            minlength: 10,
            maxlength:10,
            number:true,

          },
          email: {
            required: true,
            email: true
          },
          address: {
            required: true,
          },
          department: {
            required: true,
          },
          password: {
            minlength: 6,
            maxlength: 60,
            

          },
        },
        messages: {
          username: {
           required: "Mã nhân viên không được để trống",
         },
         fullname: {
           required: "Tên nhân viên không được để trống",
         },
         phone: {
           required: "Số điện thoại không được để trống",
           number : "Số điện thoại phải là số",
           minlength: "Số điện thoại không đúng",
         },
         email: {
           required: "Email không được để trống",
           email:"Email không đúng định dạng"
         },
         address: {
           required: "Địa chỉ không được để trống",
         },
         department: {
           required: "Phòng làm việc không được để trống",
         },
         password: {
           minlength: "Mật khẩu tối thiểu 6 kí tự",
           maxlength:"Mật khẩu tối đa 60 kí tự",
         },


       }
     });

        $('#selectedtest').on('select', function(e) {
          $(this).val('');
        });
          $("#create_company").validate({
            onfocusout: function(e)
                {  // this option is not needed
              this.element(e);       // this is the default behavior
            }, 
             rules: {
            address: {
              required: true,

            },
            linkweb: {
              required: true,

            },
            company_name: {
              required: true,

            },

         },
        messages: {
         address: {
           required: "Địa chỉ không được để trống !",
         },
         linkweb: {
           required: "Link web không được để trống !",
         },
         company_name: {
           required: "Tên công ty không được để trống !",
         },

       },
       submitHandler: function(form) {
          
                let geturlvalidate = $('#codevalidate').attr('getdata');
                let checkvalidate =  $('#codevalidate').val();
                $.ajax({
                    "type": "POST",
                    "url": geturlvalidate,
                    "data": {code: checkvalidate},
                    "success": function (ret) {
                        if (ret == 1) {
                          $('#codevalidate').parent().find('label').remove();
                            form.submit();
                        } else {
                          $('#codevalidate').parent().find('label').remove()
                            $('#codevalidate').parent().append('<label id="name-error" class="error" for="name">Mã hóa đơn đã tồn tại</label>')
                            $('#codevalidate').focus() //tự động trỏ chuột tới nếu mà xuất hiện lỗi
                        }
                    }
                });
                // return false;
            // })
        },
     });
        $("#create_bills").validate({
            onfocusout: function(e)
                {  // this option is not needed
              this.element(e);       // this is the default behavior
            },
            rules: {
             code: {
              required: true,
              min:true,
              maxlength:3              
            },

            name_customer: {
              required: true,

            },
            book_name: {
              required: true,

            },
           //  "teacher[]": {
           //    required: true,
           //  },

           //  attachs: {
           //   required: true,
           //   extension: "docx"
           // },
        //    subjectemail: {
        //     required: "Tiêu đề email không được để trống"
        // },

        // contenmail: {
        //     required: "Nội dung email không được để trống"
        // },

         },
         messages: {
          code: {
           required: "Mã hóa đơn không được để trống !",
           min: "Mã hóa đơn phải lớn hơn không",
           maxlength: "Mã hóa đơn phải nhỏ hơn hoặc bằng 3 ký tự số",
         },

         name_customer: {
           required: "Tên khách hàng không được để trống !",
         },
         book_name: {
           required: "Tên sách không được để trống !",
         },
         // attachs: {
         //   required: "HDSD không được để trống",
         //   extension: "Định dạng file phải .docx"
         // },
         // subjectemail: {
         //  required: "Tiêu đề email không được để trống"
         //          },

      // contenmail: {
      //     required: "Nội dung email không được để trống"
      //     },

       },
       submitHandler: function(form) {
          
                let geturlvalidate = $('#codevalidate').attr('getdata');
                let checkvalidate =  $('#codevalidate').val();
                $.ajax({
                    "type": "POST",
                    "url": geturlvalidate,
                    "data": {code: checkvalidate},
                    "success": function (ret) {
                        if (ret == 1) {
                          $('#codevalidate').parent().find('label').remove();
                            form.submit();
                        } else {
                          $('#codevalidate').parent().find('label').remove()
                            $('#codevalidate').parent().append('<label id="name-error" class="error" for="name">Mã hóa đơn đã tồn tại</label>')
                            $('#codevalidate').focus() //tự động trỏ chuột tới nếu mà xuất hiện lỗi
                        }
                    }
                });
                // return false;
            // })
        },
     });
    CKEDITOR.replace( 'contenmail' );
    $("form").submit( function(e) {
        var total_length = CKEDITOR.instances['contenmail'].getData().replace(/<[^>]*>/gi, '').length;
        if( !total_length ) {
            $(".results").html('');
            // $(".erroreditor").html('Nội dung email không được để trống' );

            e.preventDefault();
            // return false;
        }
    });
      $("#create_orders").validate({
            onfocusout: function(e)
                {  // this option is not needed
              this.element(e);       // this is the default behavior
            },
            rules: {
             code: {
              required: true,
              min:true,
              maxlength:3              
            },

            title: {
              required: true,
            },
            book_name: {
              required: true,

            },
            total_book: {
              required: true,

            },
            company_name: {
              required: true,

            },
            status: {
              required: true,

            },
           //  attachs: {
           //   required: true,
           //   extension: "docx"
           // },
        //    subjectemail: {
        //     required: "Tiêu đề email không được để trống"
        // },

        // contenmail: {
        //     required: "Nội dung email không được để trống"
        // },

         },
         messages: {
          code: {
           required: "Mã đơn hàng không được để trống !",
           min: "Mã đơn hàng phải lớn hơn không",
           maxlength: "Mã đơn hàng phải nhỏ hơn hoặc bằng 3 ký tự số",
         },

         title: {
           required: "Tiêu đề không được để trống !",
         },
          book_name: {
           required: "Tên sách không được để trống !",
         },
          total_book: {
           required: "Số lượng không được để trống !",
         },
          company_name: {
           required: "Tên công ty không được để trống !",
         },
          status: {
           required: "Trạng thái không được để trống !",
         },

         // attachs: {
         //   required: "HDSD không được để trống",
         //   extension: "Định dạng file phải .docx"
         // },
         // subjectemail: {
         //  required: "Tiêu đề email không được để trống"
         //          },

      // contenmail: {
      //     required: "Nội dung email không được để trống"
      //     },

       },
       submitHandler: function(form) {
          
                let geturlvalidate = $('#codevalidate').attr('getdata');
                let checkvalidate =  $('#codevalidate').val();
                $.ajax({
                    "type": "POST",
                    "url": geturlvalidate,
                    "data": {code: checkvalidate},
                    "success": function (ret) {
                        if (ret == 1) {
                          $('#codevalidate').parent().find('label').remove();
                            form.submit();
                        } else {
                          $('#codevalidate').parent().find('label').remove()
                            $('#codevalidate').parent().append('<label id="name-error" class="error" for="name">Mã hóa đơn đã tồn tại</label>')
                            $('#codevalidate').focus() //tự động trỏ chuột tới nếu mà xuất hiện lỗi
                        }
                    }
                });
                // return false;
            // })
        },
     });
    CKEDITOR.replace( 'contenmail' );
    $("form").submit( function(e) {
        var total_length = CKEDITOR.instances['contenmail'].getData().replace(/<[^>]*>/gi, '').length;
        if( !total_length ) {
            $(".results").html('');
            // $(".erroreditor").html('Nội dung email không được để trống' );

            e.preventDefault();
            // return false;
        }
    });

        $("#create_book").validate({
            onfocusout: function(e)
                {  // this option is not needed
              this.element(e);       // this is the default behavior
            },
            rules: {
             code: {
              required: true,
              min:true,
              maxlength:3              
            },

            name: {
              required: true,

            },
            // "teacher[]": {
            //   required: true,
            // },

           //  attachs: {
           //   required: true,
           //   extension: "docx"
           // },
        //    subjectemail: {
        //     required: "Tiêu đề email không được để trống"
        // },

        // contenmail: {
        //     required: "Nội dung email không được để trống"
        // },

         },
         messages: {
          code: {
           required: "Mã sách không được để trống",
           min: "Mã Sách phải lớn hơn không",
           maxlength: "Mã sách phải nhỏ hơn hoặc bằng 3 ký tự số",
         },

         name: {
           required: "Tên sách không được để trống",
         },
         // attachs: {
         //   required: "HDSD không được để trống",
         //   extension: "Định dạng file phải .docx"
         // },
         // subjectemail: {
         //  required: "Tiêu đề email không được để trống"
         //          },

      // contenmail: {
      //     required: "Nội dung email không được để trống"
      //     },

       },
       submitHandler: function(form) {
          
                let geturlvalidate = $('#codevalidate').attr('getdata');
                let checkvalidate =  $('#codevalidate').val();
                $.ajax({
                    "type": "POST",
                    "url": geturlvalidate,
                    "data": {code: checkvalidate},
                    "success": function (ret) {
                        if (ret == 1) {
                          $('#codevalidate').parent().find('label').remove();
                            form.submit();
                        } else {
                          $('#codevalidate').parent().find('label').remove()
                            $('#codevalidate').parent().append('<label id="name-error" class="error" for="name">Mã sách đã tồn tại</label>')
                            $('#codevalidate').focus() //tự động trỏ chuột tới nếu mà xuất hiện lỗi
                        }
                    }
                });
                // return false;
            // })
        },
     });
    CKEDITOR.replace( 'contenmail' );
    $("form").submit( function(e) {
        var total_length = CKEDITOR.instances['contenmail'].getData().replace(/<[^>]*>/gi, '').length;
        if( !total_length ) {
            $(".results").html('');
            // $(".erroreditor").html('Nội dung email không được để trống' );

            e.preventDefault();
            // return false;
        }
    });

        $("#edit_book").validate({
          onfocusout: function(e) 
                {  // this option is not needed
              this.element(e);       // this is the default behavior
            },
            rules: {
         

                 code: {
                     required: true,
                     min:true,
                     maxlength:3 
                },

                name: {
                    required: true,

                },
                // "teacher[]": {
                //     required: true,
                // },
               //  attachs: {
               //      extension: "docx"
               // },
                // subjectemail: {
                //     required: true,
                // },

                // contenmail: {
                //     required: true,
                // },
                // subjectemail: {
                //     required: "Tiêu đề email không được để trống"
                // },

                // contenmail: {
                //     required: "Nội dung email không được để trống"
                // },
         },
         messages: {
          code: {
          required: "Mã sách không được để trống",
          min: "Mã Sách phải lớn hơn không",
          maxlength: "Mã sách phải nhỏ hơn hoặc bằng 3 ký tự số",
         },

         name: {
           required: "Tên sách không được để trống",
         },
         // "teacher[]": {
         //   required: "Giáo viên không được để trống",
         // },
         attachs: {
           extension: "Định dạng file phải .docx"
         },
         // subjectemail: {
         //    required: "Tiêu đề email không được để trống"
         //            },

        // contenmail: {
        //     required: "Nội dung email không được để trống"
        //     },
       }
     });
        $("#editgroupbook").validate({
          onfocusout: function(e) 
                {  // this option is not needed
              this.element(e);       // this is the default behavior
            },
            rules: {
             code: {
              required: true,
              maxlength:2,
              textname:true,
            },

            name: {
              required: true,

            },

          },
          messages: {
            code: {
             required: "Mã loại sách không được để trống",
             maxlength: "tối đa 2 ký tự"
           },

           name: {
             required: "Tên loại sách không được để trống",
           },
         },
         });



        $("#groupbook").validate({
          onfocusout: function(e) 
                {  // this option is not needed
              this.element(e);       // this is the default behavior
            },
            rules: {
             code: {
              required: true,
              maxlength:2,
              textname:true,
            },

            name: {
              required: true,

            },

          },
          messages: {
            code: {
             required: "Mã loại sách không được để trống",
             maxlength: "tối đa 2 ký tự"
           },

           name: {
             required: "Tên loại sách không được để trống",
           },
         },
           submitHandler: function(form) {
          
                let geturlgroup = $('#codevalidategroup').attr('getdatagroup');
                let codegroup =  $('#codevalidategroup').val();
                $.ajax({
                    "type": "POST",
                    "url": geturlgroup,
                    "data": {code: codegroup},
                    "success": function (ret) {
                        if (ret == 1) {
                           $('#codevalidategroup').parent().find('label').remove()
                            form.submit();
                            // console.log(1)
                        } else {
                           $('#codevalidategroup').parent().find('label').remove()
                          $('#codevalidategroup').parent().append('<label id="name-error" class="error" for="name">Mã loại sách đã tồn tại</label>')
                          $('#codevalidategroup').focus() //tự động trỏ chuột tới nếu mà xuất hiện lỗi
                        }
                    }
                });
                // return false;
        },
       });
        $(".js-select-book").select2({
          tags: false,
          tokenSeparators: [',', ' ']
        });


      });


jQuery(function ($) {
  $('#republist').validate({
    rules: {
      number: {
        required: true,
        min:true,
      },

    },
    messages: {
      number: {
        required: " Trường này Không được bỏ trống",
        min:"Số lượng tái bản phải lớn hơn 0"
      },

    },
  });
});

$(document).on('click', '#detais', function(event) {
 let republish = $(this).parent().parent().find('.attr-id').attr('data-attr');
 let book_code = $(this).parent().parent().find('.attr-id').attr('data-code');
 let urlcode = $(this).attr('geturl');
 $.ajax({
   url: urlcode + republish,
   type: 'POST',
   data: {
    republish: republish,
    book_code: book_code
  },
})
 .done(function(data) {
  job = JSON.parse(data);
  let total = '';
  $.each(job[1],function(index, value) {
     $('.countrepublishs').text(value.total);
  });
  $('.totalbook').text(job[2]);
  let html = '';
  $.each(job[0],function(index, val) {
    html += '<tr>'
    html+='<td>' + val.code_item +'</td>';
    html+='</tr>';

  });
  $('#myModal #listitem').html(html);
  $('#myModal').modal('show');

})
 .fail(function() {
   console.log("error");
 });
});
$(document).on('click', '.resetform', function(event) {
  event.preventDefault();
  /* Act on the event */
     $('#republist').trigger("reset"); 
});

$(document).on('click', '#downloadcode', function(event) {
  event.preventDefault();
  $('#download').modal('show');
  let bookdownload = $(this).parent().parent().find('.attr-id').attr('data-code');
  let republishcode =  $(this).parent().parent().find('.attr-id').attr('data-attr');
  let total =  $(this).parent().parent().find('.total').attr('data-total');
  let numbercode = $('.downloadcode').text(total);
  $('.resetdowload').css('display','none');
  $('.downloadcodebook').css('display','block');
  $('.closedowload').css('display','block');
  let main = $('.attr-code').text(republishcode);
});

$(document).on('click', '.downloadcodebook', function(event) {
  $('.progress').css('display','block');
  let getdatabook = $('.attr-id').attr('data-code');
  let getnumber = $(this).parent().parent().find('.attr-code').text();

  let getcode = $('#downloadcode').attr('get-code');
  $.fn.myFunction(getcode,getnumber,getdatabook,1);

});
$(document).on('click', '.resetdowload', function(event) {
  event.preventDefault();
  /* Act on the event */
  $('.progress').css('display','none');
  $('.linkdownload').css('display','none');
});
$.fn.myFunction = function(getcode,getnumber,getdatabook, page){ 
 $.ajax({
  url: getcode + getnumber,
  type: 'POST',
  data: {
    republish: getnumber,
    book_code: getdatabook,
    page: page 
  },
})
 .done(function(data) {

  var data  = JSON.parse(data);

  $('.progress-bar-success').html(data.percent +'%');
  $('.progress-bar-success').css('width',data.percent +'%' );
  if (data.page == null) {
    $('.title-dowload1').css('display','none');
    $('.title-dowload2').css('display','block');
    $('.linkdownload').css('display','block');
    $('.resetdowload').css('display','block');
    $('.downloadcodebook').css('display','none');
    $('.closedowload').css('display','none');

    $('.linkdownload').html(data.result);

  }
  else{
    $.fn.myFunction(getcode,getnumber,getdatabook,data.page);
  }
})
 .fail(function() {
  console.log("error");
})
}
// lấy giá theo chọn sách của hóa đơn
$(document).on('change', '.number-book', function(event) {
    var book_id = $('.book_name').val();
    var number = $(this).val();
    var geturlgroup = $('#book_price').attr('data-action');
     if (book_id !='') {
        $.ajax({
                  "type": "POST",
                  "url": geturlgroup,
                  "data": {book_id: book_id,number: number},
                  "success": function (res) {
                    console.log(res);
                        // $('.date-end').val(endval);
                      // if (ret == 1) {
                      //    $('#codevalidategroup').parent().find('label').remove()
                      //     form.submit();
                      //     // console.log(1)
                      // } else {
                      //    $('#codevalidategroup').parent().find('label').remove()
                      //   $('#codevalidategroup').parent().append('<label id="name-error" class="error" for="name">Mã loại sách đã tồn tại</label>')
                      //   $('#codevalidategroup').focus() //tự động trỏ chuột tới nếu mà xuất hiện lỗi
                      // }
                  }
            });
      }else{
        alert('Hãy chọn sách trước khi chọn số lượng!');
      }
});
$(document).on('change', '.book_name', function(event) {
    var book_id = $('.book_name').val();
    var number = $(this).val();
    var geturlgroup = $('#book_price').attr('data-action1');
     if (book_id !='') {
        $.ajax({
                  "type": "POST",
                  "url": geturlgroup,
                  "data": {book_id: book_id,number: number},
                  "success": function (res) {
                    console.log(res);
                        // $('.date-end').val(endval);
                      // if (ret == 1) {
                      //    $('#codevalidategroup').parent().find('label').remove()
                      //     form.submit();
                      //     // console.log(1)
                      // } else {
                      //    $('#codevalidategroup').parent().find('label').remove()
                      //   $('#codevalidategroup').parent().append('<label id="name-error" class="error" for="name">Mã loại sách đã tồn tại</label>')
                      //   $('#codevalidategroup').focus() //tự động trỏ chuột tới nếu mà xuất hiện lỗi
                      // }
                  }
            });
      }else{
        alert('Hãy chọn sách trước khi chọn số lượng!');
      }
});


