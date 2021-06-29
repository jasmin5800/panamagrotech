function validateForm() {
  var party=$('#party_id').val()
  if(party == "0"){
    swal("error",'Please select Party',"warning","#4fa7f3"); 
    return false;
  }else{
    return true;
  }
}
function mastertlbobj($obj) {
    var gr_wt=parseFloat($obj.find('.mGr_W').val());
   
        $obj.find('.mFine').val(Math.round(gr_wt));
        
       
            calculate();
            $('form').parsley().reset();
      
}
function calculate(){
      var TFine = 0;
      $('.mFine').each(function(){        
          TFine += parseFloat($(this).val());                 
      });
      $('.tFine').val(Math.round(TFine));
      var TAmount = 0;
      $('.mAmount').each(function(){        
          TAmount += parseFloat($(this).val());                 
      });
      if(!TAmount){
        TAmount=0;
      }
      $('.tAmount').val(Math.round(TAmount));

      var rfine =  $('.rFine').val() * 1;
      var ramount = $('.rAmount').val() * 1;
      var gfine = TFine + rfine
      var gamount = TAmount + ramount
      
      $('.tAmount2').val(Math.round(gamount));
       $('.tFine2').val(Math.round(gfine));
      var pfine =  $('.pfine').val() * 1;
      var pamount = $('.pamount').val() * 1;
      var cfine = pfine - TFine;
      var camount = pamount - TAmount;
      $('.cfine').val(Math.abs(cfine));
      $('.camount').val(Math.abs(camount));
      (cfine > 0) ? $('.cfines').text("db") : $('.cfines').text("cr");
      (camount > 0) ? $('.camounts').text("db") : $('.camounts').text("cr");
      (cfine > 0) ? $('.cfinest').val("db") : $('.cfinest').val("cr");
      (camount > 0) ? $('.camountst').val("db") : $('.camountst').val("cr");
}
  $(document).ready(function() {
      $('form').parsley();      
      var xChildTr=$("#xChildTr").html();
      var xMsaterTr=$("#xMsaterTr").html();
      if(method=="add"){
          $("#xMsaterTr").find('.masterRmvBtn').removeClass('masterRmvBtn');
      }else{
          $("#xMsaterTr").remove();
          calculate();
      }
        $('body').on('click','.masterdAddBtn', function(){
             var a=$('#mastertbl > tbody > tr:last').before("<tr>"+xMsaterTr+"</tr>");
             $("select").select2();
        });
        $('body').on('click','.masterRmvBtn', function(){
              var obj=$(this).parents('tr').remove();
              $(".sItem_id").each(function() {
                var tr=$(this).parents('tr');
                mastertlbobj(tr);
              });
        });
        $('body').on('keyup','.mGr_W', function(){
              var obj=$(this).parents('tr');
              mastertlbobj(obj)
        });
        $('body').on('keyup','.mBadlo', function(){
              var obj=$(this).parents('tr');
              mastertlbobj(obj)
        });
        $('body').on('keyup','.mTf', function(){
              var obj=$(this).parents('tr');
              mastertlbobj(obj)
        });
       $('body').on('keyup','.mAmount', function(){
              var obj=$(this).parents('tr');
              mastertlbobj(obj)
        });
        $('body').on('keyup','.rFine', function(){
            calculate();
        });
       $('body').on('keyup','.rAmount', function(){
        calculate();
        });
       
        $('body').on('click','[data-id=masterDltBtn]', function(){
          console.log("hello");
            var id=$(this).data("value"); 
            var obj=$(this).parents('tr');
             swal({
                   title: 'Are you sure?',
                   text: "You won't be able to revert this!",
                   type: 'warning',
                   showCancelButton: true,
                   confirmButtonText: 'Yes, Delete',
                   cancelButtonText: 'No, Cancel!',
                   confirmButtonClass: 'btn btn-success',
                   cancelButtonClass: 'btn btn-danger m-l-10',
                   buttonsStyling: false
               }).then(function () {
                   $.ajax({
                       type: "POST",
                       url: "../purchseitem_delete/"+id+"",
                       success: function(data){
                         var data  = JSON.parse(data);
                         if(data.status=="success"){
                            swal('Deleted!',data.msg,'success');
                            obj.remove();
                         }else{
                            swal("error",data.msg,"warning","#4fa7f3");  
                         }              
                       }
                    })
               }, function (dismiss) {
                   // dismiss can be 'cancel', 'overlay',
                   // 'close', and 'timer'
                   if (dismiss === 'cancel') {
                       swal(
                           'Cancelled',
                           'Your imaginary file is safe :)',
                           'error'
                       )
                   }
               })
        });
        $('body').on('change','#party_id', function(){
				
            var Party_Id = $(this).val();
      
            $.ajax({
                url: "https://omcasting.in/RoughInvoice/get_opening/"+Party_Id,
                 type: "POST",
                success: function(result)
                {
                    var res = result.split(",");
                    $('.pfine').val(Math.abs(res[1]));
                    
                    $('.pamount').val(Math.abs(res[0]));
                    (res[1] > 0) ? $('.pfines').text("db") : $('.pfines').text("cr");
                    (res[0] > 0) ? $('.pamounts').text("db") : $('.pamounts').text("cr");
                    (res[1] > 0) ? $('.pfinest').val("db") : $('.pfinest').val("cr");
                    (res[0] > 0) ? $('.pamountst').val("db") : $('.pamountst').val("cr");
                }	
            });
            
            return false;
        });
        $("select").select2();
    });