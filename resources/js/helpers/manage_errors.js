
import { toast } from 'vue3-toastify'
import 'vue3-toastify/dist/index.css';
export function  showErrorProps_Toast(errors_obj){
    // errors_obj is page.props.errors
    Object.values(errors_obj).forEach((err)=>{
          //console.log('1117 error ::: ',err)
          toast.error(err)
    })
}



export function MyErrorHandling(errorResponse,log_error=true,toast_error=true){

       var error_object = {errors:[],message:null,request:null,data:null,status:null, detaiedMessage:null}

      if (errorResponse.response) {  
        // The request was made and the server responded with a status code  
                     if(errorResponse.response.status==422){
                       // validation error
                       
                       /////if(toast_error) toast.error(errorResponse.response.data.message || 'خطا در  اعتبارسنجی اطلاعات ورودی  ')
                       ////////////form.errors=Object.values(errorResponse.response.data?.errors).flat() 
                       error_object.errors = Object.values(errorResponse.response.data?.errors ?? []).flat() 
                       error_object.message = errorResponse.response.data.message || 'خطا در  اعتبارسنجی اطلاعات ورودی  ' 
                     }else{
                        ////if(toast_error) toast.error(errorResponse.response.data.message || 'خطای نامشخص')
                        error_object.message = errorResponse.response.data.message || 'خطا نامشخص    ' 
                     }
                //.error('Error Status:', errorResponse.response.status);  
                    /////if(log_error) console.error('errorResponse.response.data', errorResponse.response.data,'errorResponse.response.status: ',errorResponse.response.status); 
                    error_object.data = errorResponse.response.data
                    error_object.status = errorResponse.response.status
               // console.error('Error Message:', errorResponse.response.data.message || 'No specific message provided');  
        } else if (errorResponse.request) {  
        // The request was made but no response was received  
              /////if(log_error) console.error('No response received:', errorResponse.request);  
              ///if(toast_error)  toast.error('  خطا: پاسخی دریافت نشد  ')
              error_object.message='  خطا: پاسخی دریافت نشد  '
              error_object.request= errorResponse.request
        } else {  
        // Something happened in setting up the request  
                ///if(log_error)   console.error('Error:', errorResponse.message);  
                //if(toast_error)  toast.error('خطا در ارسال درخواست   ')
                ////error_object.message= 'No response received:'+errorResponse.request 

                error_object.message = 'خطا در ارسال درخواست   '
                error_object.detaiedMessage = errorResponse.message
        }
        
        return error_object
}