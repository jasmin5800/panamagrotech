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
    var bag_wt=parseFloat($obj.find('.mBag_W').val());
    if(!bag_wt){
      bag_wt=0;
    }
    var nt_wt=gr_wt-bag_wt;    
    $obj.find('.mNet_W').val(Math.round(nt_wt));
    var ghat=parseFloat($obj.find('.mGhat').val());
    if(!ghat){
        ghat=0;
    }
    nt_wt=parseFloat($obj.find('.mNet_W').val())
    var tl_wt=ghat+nt_wt;
    $obj.find('.mTtl_W').val(Math.round(tl_wt));
    var mTouch=parseFloat($obj.find('.mTouch').val());
    var mWastage=parseFloat($obj.find('.mWastage').val());
    if(!mTouch){
    }else{
        var T_G=mTouch+mWastage;
        $obj.find('.mT_G').val(T_G);
        var mT_G=parseFloat($obj.find('.mT_G').val());
        var mTtl_W=parseFloat($obj.find('.mTtl_W').val());
            if(!mT_G || !mTtl_W)
            {
              return false;
            }else{
                var fine=(mT_G*mTtl_W/100);
                $obj.find('.mFine').val(Math.round(fine));
                var mNos=parseFloat($obj.find('.mNos').val());
                var mRate=parseFloat($obj.find('.mRate').val());
                var amount=mRate*mNos;
                $obj.find('.mAmount').val(Math.round(amount));
                var mTtl_W=parseFloat($obj.find('.mTtl_W').val());
                  if(!mTtl_W){
                  }else{
                    calculate();
                    $('form').parsley().reset();
                  }
            }
    }  
    /**/
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
}
    $(document).ready(function() {
      $('form').parsley();      
      var xChildTr=$("#xChildTr").html();
      var xMsaterTr=$("#xMsaterTr").html();
      if(method=="add"){
          $("#xMsaterTr").find('.masterRmvBtn').removeClass('masterRmvBtn');
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
        $('body').on('keyup','.mGhat', function(){
              var obj=$(this).parents('tr');
              mastertlbobj(obj)
        });
        $('body').on('keyup','.mBag_W', function(){
              var obj=$(this).parents('tr');
              mastertlbobj(obj)
        });
        $('body').on('keyup','.mNet_W', function(){
              var obj=$(this).parents('tr');
              mastertlbobj(obj)
        });
        $('body').on('keyup','.mTouch', function(){
              var obj=$(this).parents('tr');
              mastertlbobj(obj)
        });
        $('body').on('keyup','.mLabour', function(){
              var obj=$(this).parents('tr');
              mastertlbobj(obj)
        });
        $('body').on('keyup','.mWastage', function(){
              var obj=$(this).parents('tr');
              mastertlbobj(obj)
        });
        $('body').on('keyup','.mRate', function(){
              var obj=$(this).parents('tr');
              mastertlbobj(obj)
        });
        $('body').on('keyup','.mNos', function(){
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