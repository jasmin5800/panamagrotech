function validateForm() {
  var party=$('#party_id').val()
  if(party == "0"){
    swal("error",'Please select Party',"warning","#4fa7f3"); 
    return false;
  }else{
    return true;
  }
}

$('body').on('change','.sItem_id', function(){
				
    var parent = $(this).parents('tr');
    var Item_Id = $(this).val();
   
    $.ajax({
        url: "https://omcasting.in/Garanu/get_touch/"+Item_Id,
         type: "POST",
        success: function(result)
        {
             $(parent).find('.mtouch').val(result);
            Quantity = $(parent).find('.mGr_W').val() * 1;
            Total = result * Quantity / 100;
            $(parent).find('.mFine').val(Total);
            
            calculate_total();
        }	
    });
    
    return false;
});

function mastertlbobj($obj) {
    var gr_wt=parseFloat($obj.find('.mGr_W').val());
   
    var nt_wt=gr_wt;    
     var mBadlo=parseFloat($obj.find('.mtouch').val());
    var fine=mBadlo*nt_wt / 100;
    
    $obj.find('.mFine').val(Math.round(fine));
    
    calculate();
    $('form').parsley().reset();
      
}
function calculate(){
      var TFine = 0;
      $('.mFine').each(function(){        
          TFine += parseFloat($(this).val());                 
      });
      $('.tFine').val(Math.round(TFine));
      var GWeight = 0;
      $('.mGr_W').each(function(){        
        GWeight += parseFloat($(this).val());                 
      });
      var tweight = 0;
      $('.mFine').each(function(){        
        tweight += parseFloat($(this).val());                 
      });
      $('.tweight').val(Math.round(tweight));
      $('.t_gweight').val(Math.round(GWeight));
      
        var r_garnu =  $('.rGaranu').val();
         var r_copper = r_garnu - GWeight;
         $('.r_copper').val(Math.round(r_copper));
        
       
         var t_copper =  $('.t_copper').val();
         var f_copper = r_copper * t_copper /100;
         $('.f_copper').val(parseFloat(f_copper).toFixed(0));

         var total_fine = tweight + f_copper;
         $('.fweight').val(Math.round(total_fine));
         var s_touch1 =  $('.s_Touch1').val();
            var rc_garanu = total_fine / s_touch1 *100;
            $('.rc_garanu').val(Math.round(rc_garanu));

            var finalfine = rc_garanu - GWeight;
            $('.finalfine').val(Math.round(finalfine));

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
        $('body').on('keyup','.mGr_W', function(){
              var obj=$(this).parents('tr');
              mastertlbobj(obj)
        });
        $('body').on('keyup','.mtouch', function(){
              var obj=$(this).parents('tr');
              mastertlbobj(obj)
        });
        $('body').on('keyup','.s_Touch', function(){
            var STouch = $(this).val();
            $('.s_Touch1').val(STouch);

            var TFine = $('.tFine').val();
            var r_garanu = TFine / STouch * 100;
            $('.rGaranu').val(Math.round(r_garanu));
            calculate();
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
        
        $("select").select2();
    });