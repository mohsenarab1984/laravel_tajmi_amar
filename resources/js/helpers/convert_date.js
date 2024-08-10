import moment from 'moment-jalaali'

export function convertGregorianToPersian(gregorianDate) {  
    return moment(gregorianDate).format('jYYYY/jMM/jDD'); // Convert Gregorian to Persian date
       
}  

export function convertPersianToGregorian(persianDate) {  
    return moment(persianDate, 'jYYYY/jMM/jDD').format('YYYY-MM-DD'); // Convert Persian to Gregorian date  
} 

export function convertGregorianToPersianDatetime(gregorianDatetime) {  
    return moment(gregorianDatetime).format('jYYYY/jMM/jDD HH:mm:ss'); // Convert Gregorian to Persian datetime  
}  


export function convertPersianToGregorianDatetime(persianDatetime) {  
    return moment(persianDatetime, 'jYYYY/jMM/jDD HH:mm:ss').format('YYYY-MM-DD HH:mm:ss'); // Convert Persian to Gregorian datetime  
}

export function persianLocalFa(gregorianDatetime){
    moment(gregorianDatetime).locale('fa').format('jYYYY/jM/jD HH:mm:ss')
}

// var pd1='1403/05/17'
// var gd1="2024-08-08"
// var gdt1="2022-03-21 14:30:00"
// var pdt1="1401/01/01 14:30:00"

// console.log('convertPersianToGregorian: ',pd1,'-->',convertPersianToGregorian(pd1));
// console.log('convertPersianToGregorian: ',gd1,'-->',convertGregorianToPersian(gd1)); 
// console.log('convertGregorianToPersianDatetime: ',gdt1,'-->',convertGregorianToPersianDatetime(gdt1));
// console.log('convertPersianToGregorianDatetime: ',pdt1,'-->',convertPersianToGregorianDatetime(pdt1));

