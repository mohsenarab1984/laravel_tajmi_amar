
     
     <template>

              
     
        <div class="my-2 py-2" style="padding: 0 3rem;">
                <div class="mx-3 d-inline-block">
                
                    
                
                    <span class="ps-5">  <strong>  نام گزارش    :  </strong>  </span class="ps-5">  {{ item.title }}  
                </div>
    
                

                <div v-if="is_adder(item)">
                      <div v-if="showIntputFiledBox">

                          <input v-if="is_number(item)" v-model="form.input_value_new"  /> 
                          <input v-else type="checkbox" v-model="form.input_ticket_new" >

                          <div class="mx-2 mb-3 d-inline-block" :title="form.date_fa">
                               <div for="title" class="d-inline-block  ms-2 me-5" style="display: inline-block;">تاریخ مربوطه : </div>
                               <DatePicker v-model="form.date_fa" class="d-inline-block"></DatePicker>
                    
                          </div>
                          <!-- <input   type="check" > -->
                          <button @click="updateValue" class="btn btn-sm btn-primary me-2">   ذخیره </button>
                          <button @click="closeInputfiledBox" class="mx-2">   بستن </button>
                      </div>

                      <div>
                             <div class="d-inline-block border py-1 px-3 mx-2" v-if="item.type=='number' && item.input_value_new">
                                         {{ item.input_value_new }}
                            </div>
                             <div class="d-inline-block border py-1 px-3 mx-2" v-if="item.type !='number' && item.input_ticket_new!=NULL">
                                     <input type="checkbox" :checked="item.input_ticket_new == 1"   />
                            </div>
                            <div class="d-inline-block border py-1 px-3 mx-2" v-if="item_accepted">
                                        تایید شده
                            </div>
                            <div class="d-inline-block border py-1 px-3 mx-2" v-if="item_rejected">
                                            رد شده
                            </div>

                            <div class="d-inline-block border py-1 px-3 mx-2" v-if="item.change">
                                         در دست بررسی
                            </div>

                            <div class="d-inline-block   py-1 px-3 mx-2" >
                                        <button @click="openInputfieldBox">ورود مقدار   <span v-if="has_value">    جدید</span>  </button>
                                        
                            </div>
                            
                      </div>
                </div>

                <div class="border rounded p-2" v-if="is_verifier(item) && item.change==1 ">
                        <h6>  <strong>  کادر تایید کننده  </strong>  </h6>
                       <div class="d-inline-block">

                           {{ form.input_value_new }}
                       </div>
                       <div class="d-inline-block " v-if="item_no_action">
                             <button class="btn btn-sm btn-success mx-2" @click="ActionVerify('yes')"> تایید </button>
                             <button class="btn btn-sm btn-danger mx-2" @click="ActionVerify('no')"> رد </button>
                       </div>
                       
                </div>
    
                <div>

                            <div class="mx-3  d-inline-block">
                                <div for="title" class="form-label d-inline-block" >نام  وارد کننده : {{ adder.name }}  </div>
                                
                            </div>
                
                            <div class="mx-3  d-inline-block me-5">
                                <div for="title" class="form-label d-inline-block" >نام    تایید کننده : {{ verifier.name  }} </div>
                                
                            </div>
                
                            <div class="mx-3  d-inline-block me-5">
                                <div for="title" class="form-label d-inline-block" >نام    مشاهده کننده :   </div>

                                <div class="d-inline-block" style="max-width: 400px;">
                                        <div v-for="viewer in viewers " class="d-inline-block border mx-2 p-1">
                                                {{ viewer?.name }}
                                        </div>

                                        <!-- <div>
                                            {{ viewers }}
                                        </div> -->
                                </div>
                                
                            </div>

                            <!-- <div>
                                item.adder:   {{ item.adder }}
                            </div>
                            <div>
                                item.verifier:   {{ item.verifier }}
                            </div>
                            <div>
                                item.viewers:   {{ item.viewers }}
                            </div> -->
                </div>

                <div>
                      <div class="cursor_pointer" style="color: green; " @click="toggleShowHistory"> 
                        <span v-if="!showHistory">مشاهده</span> <span v-if="showHistory">X</span> <span v-if="showHistory">بستن</span>   تاریخچه مقادیر  
                     </div>
                      
                      <div class="border p-2 rounded mb-2" v-if="showHistory">

                          <div v-for="(item_history,index) in JSON.parse(item.history) ">
                             <span class="ms-5"> {{ item_history.input_value }}</span> 
                             
                             <span>تاریخ تایید:</span>
                             <span class="mx-3">  {{  jalaliDate(item_history.updated_at) }}</span>

                             <span>تاریخ ورود:</span>
                             <span class="mx-3">  {{  jalaliDate(item_history.added_at) }}</span>

                             <span v-if="item_history.related_date">تاریخ مربوطه:</span>
                             <span class="mx-3">  {{item_history.related_date ? datetime_en_to_date_fa(item_history.related_date) :'' }}</span>
                             
                             
                          </div>
                      </div>
                     
                </div>

                
               
    
                
                
        </div>

   
</template>



<script setup>
import { useForm } from '@inertiajs/vue3';
import { usePage } from '@inertiajs/vue3';
import { computed, ref, watch, watchEffect } from 'vue';
import { toast } from 'vue3-toastify'
import 'vue3-toastify/dist/index.css';
import moment from 'moment-jalaali';
import DatePicker from 'vue3-persian-datetime-picker'
import {convertGregorianToPersianDatetime as datetime_en_to_fa, convertPersianToGregorian as date_fa_to_en} from '@js/helpers/convert_date'

function datetime_en_to_date_fa (date){
    return moment(date).format('jYYYY/jMM/jDD')
}






const page = usePage();
const user = computed(() => page.props.auth?.user ?? null);

const showHistory=ref(false)
const setShowHistory = (val)=> { showHistory.value = val }
const toggleShowHistory = ()=> { showHistory.value = !showHistory.value }

// computed has_value = ()=>{
//     return item_accepted() || item_rejected() || item.change
// }

const has_value = computed(()=>{
    return item_accepted.value || item_rejected.value || props.item.change
})

// تاریخ شمسی محلی  timezone convert jajali local persian 
const jalaliDate= computed(()=>(date)=>moment(date).locale('fa').format('jYYYY/jM/jD HH:mm:ss'))

// const jalaliDate_ = moment(createdAt).locale('fa').format('jYYYY/jM/jD HH:mm:ss');


const props = defineProps({
    item: Object
})



const showIntputFiledBox = ref(false)

function closeInputfiledBox(){
    showIntputFiledBox.value = false
}
function openInputfieldBox(){
    showIntputFiledBox.value = true
}

function showError(){
    Object.values(page.props.errors).forEach((err)=>{
          //console.log('1117 error ::: ',err)
          toast.error(err)
    })
}


const form = useForm({
    input_value_new:null,
    input_ticket_new:null,
    type:null,
    date_fa:null,
    date_en:null

})

watchEffect(()=>{
    form.date_en = form.date_fa ? date_fa_to_en(form.date_fa) : '' 
  })

const form_verifier = useForm({
    accept:null,
    

})

const selected_ticket = computed(()=>props.item.input_ticket_new==1)
watchEffect(()=>{
    form.input_value_new =  props.item.input_value_new
    form.input_ticket_new = props.item.input_ticket_new ==1
    form.type = props.item.type
    form_verifier.accept = props.item.accept
})

function ActionVerify(action){
    form_verifier.accept = action
    form_verifier.put(`/admin/report/${props.item.id}/verifier`,{
            preserveScroll:true,
            onError: (errors) => {
                   
                    showError()
                
            },
            onSuccess:(response)=>{
            
                toast.success('عملیات جدید با موفقیت ساخته شد')
                form.clearErrors()
                
            }
    });
}

function updateValue(){

    console.log('form: ',form)

    form.put(`/admin/report/${props.item.id}/adder`,{
            preserveScroll:true,
            onError: (errors) => {
                   
                    showError()
                
            },
            onSuccess:(response)=>{
            
                toast.success('عملیات جدید با موفقیت ساخته شد')
                form.clearErrors()
                closeInputfiledBox()
                
            }
    })
}
 const is_number = computed(()=>(item)=>item.type == 'number')     

const is_adder = computed(()=>(item)=>user?.value.id == item.adder_id  )
const is_verifier = computed(()=>(item)=>user?.value.id == item.verifier_id  )

const item_accepted = computed(()=>props.item.accept=='yes')
const item_rejected = computed(()=>props.item.accept=='no')
const item_no_action = computed(()=>!props.item.accept)


const {title, adder, viewer, verifier, viewers } = props.item

</script>