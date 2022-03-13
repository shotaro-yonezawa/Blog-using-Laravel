var storedWord;
var storedCompany;
var storedUpperPriceLimit;
var storedLowerPriceLimit;
var storedUpperStockLimit;
var storedLowerStockLimit;
var img;
var pressedButton;
var sortToggle;
var selectedId;
var imageURL;

$(function () {
      $.ajax({
        url: 'ajaxGet', //通信先アドレスで、このURLをあとでルートで設定します
        method: 'GET', //HTTPメソッドの種別を指定します。1.9.0以前の場合はtype:を使用。
      })
      .done(function (data){
        $('#productList').empty();
        $.each(data, function(key, value){
          if(value.product_image  === null){
            img = "No Data";
          }else{
            imageURL = value.product_image;
            imageURL = imageURL.replace("public","storage");
            img = "<img class='product_image' src='"+imageURL+"' alt='' width='100px' height='100px'>";
          }
          $('#productList').append(
            "<tr><td>"+value.id+"</td><td>"+img+"</td><td>"+value.product_name+"</td><td>"+value.price+"</td><td>"+value.stock+"</td><td>"+value.company_name+"</td> <td><a class='btn btn-outline-dark' href='/product/"+value.id+"'>詳細</a></td><td><button data-id=" + value.id +" class='btn btn-outline-danger deleteBtn'>削除</button></td></tr>"
          );
        });
      })
      .fail(function () {
        console.log('fail'); 
        console.log(data);
      });

    $('#ajaxSearch').on('click', function () { //onはイベントハンドラー
      $.ajax({
        headers: { //HTTPヘッダ情報をヘッダ名と値のマップで記述
          'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
        },  //↑name属性がcsrf-tokenのmetaタグのcontent属性の値を取得
        url: 'ajaxSearch', //通信先アドレスで、このURLをあとでルートで設定します
        method: 'POST', //HTTPメソッドの種別を指定します。1.9.0以前の場合はtype:を使用。
        dataType:'json',
        data:{
          "word":$('#word').val(),
          "company":$('#company').val(),
          "upperPriceLimit":$('#upperPriceLimit').val(),
          "lowerPriceLimit":$('#lowerPriceLimit').val(),
          "upperStockLimit":$('#upperStockLimit').val(),
          "lowerStockLimit":$('#lowerStockLimit').val()
        }
      })
      .done(function (data){
        $('#productList').empty();
        $.each(data, function(key, value){
          if(value.product_image  === null){
            img = "No Data";
          }else{
            imageURL = value.product_image;
            imageURL = imageURL.replace("public","storage");
            img = "<img class='product_image' src='"+imageURL+"' alt='' width='100px' height='100px'>";
          }
          $('#productList').append(
              "<tr><td>"+value.id+"</td><td>"+img+"</td><td>"+value.product_name+"</td><td>"+value.price+"</td><td>"+value.stock+"</td><td>"+value.company_name+"</td> <td><a class='btn btn-outline-dark' href='/product/"+value.id+"'>詳細</a></td><td><button data-id=" + value.id +" class='btn btn-outline-danger deleteBtn'>削除</button></td></tr>"
          );
        });
        storedWord = $('#word').val();
        storedCompany = $('#company').val();
        storedUpperPriceLimit = $('#upperPriceLimit').val();
        storedLowerPriceLimit = $('#lowerPriceLimit').val();
        storedUpperStockLimit = $('#upperStockLimit').val();
        storedLowerStockLimit = $('#lowerStockLimit').val();
        $('#storedWord').val(storedWord);
        $('#storedCompany').val(storedCompany);
        $('#storedUpperPriceLimit').val(storedUpperPriceLimit);
        $('#storedLowerPriceLimit').val(storedLowerPriceLimit);
        $('#storedUpperStockLimit').val(storedUpperStockLimit);
        $('#storedLowerStockLimit').val(storedLowerStockLimit);
        $('.text-danger').empty();
      })
      .fail(function () {
        console.log('fail'); 
      });
    });

    $('.sortButton').on('click', function () {
      pressedButton = $(this).data('pressed');
      sortToggle = $(this).data('sort');
      if(sortToggle === 'asc'){
        $(this).data('sort','desc');
      }else{
        $(this).data('sort','asc');
      }
      $.ajax({
        headers: { //HTTPヘッダ情報をヘッダ名と値のマップで記述
          'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
        },  //↑name属性がcsrf-tokenのmetaタグのcontent属性の値を取得
        url: 'ajaxSort', //通信先アドレスで、このURLをあとでルートで設定します
        method: 'POST', //HTTPメソッドの種別を指定します。1.9.0以前の場合はtype:を使用。
        dataType:'json',
        data:{
          "word":$('#storedWord').val(),
          "company":$('#storedCompany').val(),
          "upperPriceLimit":$('#storedUpperPriceLimit').val(),
          "lowerPriceLimit":$('#storedLowerPriceLimit').val(),
          "upperStockLimit":$('#storedUpperStockLimit').val(),
          "lowerStockLimit":$('#storedLowerStockLimit').val(),
          "pressedButton":$(this).data("pressed"),
          "sortToggle":$(this).data("sort")
        }
      })
      .done(function (data){
        $('#productList').empty();
        $.each(data, function(key, value){
          if(value.product_image  === null){
            img = "No Data";
          }else{
            imageURL = value.product_image;
            imageURL = imageURL.replace("public","storage");
            img = "<img class='product_image' src='"+imageURL+"' alt='' width='100px' height='100px'>";
          }
          // if(value.product_image === undefined){
          //   img = "undefined2";
          // }
          $('#productList').append(
              "<tr><td>"+value.id+"</td><td>"+img+"</td><td>"+value.product_name+"</td><td>"+value.price+"</td><td>"+value.stock+"</td><td>"+value.company_name+"</td> <td><a class='btn btn-outline-dark' href='/product/"+value.id+"'>詳細</a></td><td><button data-id=" + value.id +" class='btn btn-outline-danger deleteBtn'>削除</button></td></tr>"
          );
          $('#storedPressedButton').val(pressedButton);
          $('#storedSortToggle').val(sortToggle);
        });
        $('.text-danger').empty();
      })
      .fail(function () {
        console.log('fail'); 
      });
    });

    $(document).on('click','.deleteBtn',function () { //onはイベントハンドラー
      sortToggle = $('#storedSortToggle').val();
      if(sortToggle === 'asc'){
        sortToggle = 'desc';
      }else{
        sortToggle = 'asc';
      }
      if(confirm('削除してよろしいですか？')){
        $.ajax({
          headers: { //HTTPヘッダ情報をヘッダ名と値のマップで記述
            'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
          },  //↑name属性がcsrf-tokenのmetaタグのcontent属性の値を取得
          url: 'ajaxDelete', //通信先アドレスで、このURLをあとでルートで設定します
          method: 'POST', //HTTPメソッドの種別を指定します。1.9.0以前の場合はtype:を使用。
          dataType:'json',
          data:{
            "id":$(this).data('id'),
            "word":$('#storedWord').val(),
            "company":$('#storedCompany').val(),
            "upperPriceLimit":$('#storedUpperPriceLimit').val(),
            "lowerPriceLimit":$('#storedLowerPriceLimit').val(),
            "upperStockLimit":$('#storedUpperStockLimit').val(),
            "lowerStockLimit":$('#storedLowerStockLimit').val(),
            "pressedButton":$('#storedPressedButton').val(),
            "sortToggle":sortToggle
          }
        })
        .done(function (data){
          $('#productList').empty();
          $.each(data, function(key, value){
            if(value.product_image  === null){
              img = "No Data";
            }else{
              imageURL = value.product_image;
              imageURL = imageURL.replace("public","storage");
              img = "<img class='product_image' src='"+imageURL+"' alt='' width='100px' height='100px'>";
            }
            $('#productList').append(
                "<tr><td>"+value.id+"</td><td>"+img+"</td><td>"+value.product_name+"</td><td>"+value.price+"</td><td>"+value.stock+"</td><td>"+value.company_name+"</td> <td><a class='btn btn-outline-dark' href='/product/"+value.id+"'>詳細</a></td><td><button data-id=" + value.id +" class='btn btn-outline-danger deleteBtn'>削除</button></td></tr>"
            );
          });
          $('.text-danger').empty();
        })
        .fail(function () {
          console.log('fail');
          console.log(data);
        });
      }
    });
});