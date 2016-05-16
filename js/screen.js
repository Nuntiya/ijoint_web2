

function trimValue(obj) {
    var temp = Trim(obj.value);
    obj.value = temp;
}
function Trim(TRIM_VALUE){
    if(TRIM_VALUE.length < 1){
        return"";
    }
    TRIM_VALUE = RTrim(TRIM_VALUE);
    TRIM_VALUE = LTrim(TRIM_VALUE);
    if(TRIM_VALUE==""){
        return "";
    }
    else{
        return TRIM_VALUE;
    }
}

function showImagePreview(ele,$targetElement)
{
    $targetElement.show();
    $targetElement.attr('src', ele.value); // for IE
    if (ele.files && ele.files[0]) {

        var reader = new FileReader();

        reader.onload = function (e) {
            $targetElement.attr('src', e.target.result);
        }

        reader.readAsDataURL(ele.files[0]);
    }
}

function resetImagePreview($targetElement){
    $targetElement.attr('src','');
}

function RTrim(VALUE){
    var w_space = String.fromCharCode(32);
    var v_length = VALUE.length;
    var strTemp = "";
    if(v_length < 0){
        return"";
    }
    var iTemp = v_length -1;

    while(iTemp > -1){
        if(VALUE.charAt(iTemp) == w_space){
        }
        else{
            strTemp = VALUE.substring(0,iTemp +1);
            break;
        }
        iTemp = iTemp-1;

    } //End While
    return strTemp;

} //End Function

function LTrim(VALUE){
    var w_space = String.fromCharCode(32);
    if(v_length < 1){
        return"";
    }
    var v_length = VALUE.length;
    var strTemp = "";

    var iTemp = 0;

    while(iTemp < v_length){
        if(VALUE.charAt(iTemp) == w_space){
        }
        else{
            strTemp = VALUE.substring(iTemp,v_length);
            break;
        }
        iTemp = iTemp + 1;
    } //End While
    return strTemp;
}
function CheckNum() {
    if (event.keyCode < 48 || event.keyCode > 57) {
        event.returnValue = false;
    }
}


function chkNotThaiChaOnly(e) {
    if(event.keyCode >= 3585 && event.keyCode <= 3673) {
        event.returnValue = false;
    }
}

function setElementValue(elementName,value){
    document.getElementsByName(elementName)[0].value=value;
}


function CommaFormatted(amount) {
    var delimiter = ","; // replace comma if desired
    var a = amount.split('.',2)
    var d = a[1];
    var i = parseInt(a[0]);
    if(isNaN(i)) { return ''; }
    var minus = '';
    if(i < 0) { minus = '-'; }
    i = Math.abs(i);
    var n = new String(i);
    var a = [];
    while(n.length > 3) {
        var nn = n.substr(n.length-3);
        a.unshift(nn);
        n = n.substr(0,n.length-3);
    }
    if(n.length > 0) { a.unshift(n); }
    n = a.join(delimiter);
    if(d.length < 1) { amount = n; }
    else { amount = n + '.' + d; }
    amount = minus + amount;
    return amount;
}

function print(url){
    var bConfirm = confirm("คุณต้องการพิมพ์รายงาน?");
    if(bConfirm){
        $.ajax({
            url: url
        });
    }

}

function checkWordNumber(str) {
    if (str.indexOf(".") >= 0)
        chkInteger();
    else
        chkIntAndComma();
}

function chkInteger(e){
    var keyCode = getKeyCode(e);
    if ((keyCode < 48) || (keyCode > 57)) {
        cancelEvents(e);
    }
}
function chkIntAndComma(e) {
    var keyCode = getKeyCode(e);
    if ((keyCode != 46) && (keyCode < 48) || (keyCode > 57))
        cancelEvents(e);
}
function getKeyCode(e){
    var keynum;
    if (!e) {
        e = window.event;
    }
    if(window.event) {  // for IE, e.keyCode or window.event.keyCode can be used
        keynum = e.keyCode;
    } else if(e.which) {   		// for  NS4, FF compatible
        keynum = e.which;
    } else if(e.charCode) {  		//also NS 6+, Mozilla 0.9+
        keynum = e.charCode;
    }else{ 		// no event, so pass through
        keynum = 0;
    }
    return keynum;
}

function cancelEvents(e){
    if (window.event){
        window.event.returnValue = false;
        //window.event.cancelBubble = true;
    }else{
        if(e.charCode>0 && e.which>0 ){
            e.preventDefault();
        }
    }
}

function checkNumFloat(obj,min,max){
    if (obj.value != "") {
        obj.value = parseFloat(obj.value)+""; // แปลงจาก 01234.xx เป็น 1234.xx
        checkInputComma(obj);  // ถ้าพิม xxx ก็ให้เป็น xxx.00
        if (min >= 0 && max > 0) 	{
            callMaxMin(obj,min,max); // ตรวจดูว่าค่าที่กรอกเกินค่าสูงสุด หรือต่ำกว่าค่าต่ำสุดหรือไม่
        }
        insertComma(obj); //123456 ==> 123,456
    }
}

function checkInputComma(obj) {
    var temp = obj.value.split(".");
    if (temp.length == 2)  {
        if (temp[1].length == 0) {
            obj.value = obj.value + "00";
        }
        else if (temp[1].length == 1) {
            obj.value = obj.value + "0";
        }
    }
    else {
        obj.value = obj.value + ".00";
    }
}

function callMaxMin(obj,min,max) {
    if (!checkMaxMin(obj.value,min,max)) {
        alert(MyAlert[1] + min + MyAlert[2] + max + MyAlert[3]);
        obj.value = min;
        obj.select();
    }
}
function insertComma(obj) {
    var formatnum = '', checkcomma = 0 ,  text  , tempindexcomma = obj.value.indexOf(".");

    if (tempindexcomma >= 0)
        text = obj.value.substring(0,tempindexcomma); // ตรวจสอบค่า obj มีจุดทศนิยม
    else
        text = obj.value; // ตรวจสอบค่า obj ไม่มีจุดทศนิยม
    for (var i = text.length; i > 0; i--) {
        if (checkcomma == 3) {
            formatnum = text.substring(i-1,i)+ ',' + formatnum;
            checkcomma = 1;
        }
        else {
            formatnum = text.substring(i-1,i) + formatnum;
            checkcomma++;
        }
    }

    if (tempindexcomma >= 0) // ถ้ามีจุดทศนิยมจะทำการการส่งค่าเป็นแบบทศนิยม
        formatnum = formatnum + obj.value.substring(tempindexcomma,obj.value.length);
    obj.value = formatnum;
}

function checkMaxMin(numcheck,nummin,nummax){
    if ((   parseFloat(numcheck) > parseFloat(nummax))  ||  (parseFloat(numcheck) < parseFloat(nummin)))
        return false;
    else
        return true;
}

function checkComma(obj,limitcomma){
    var tempspl = obj.value.split(".") , tempstr ;
    if (tempspl.length == 2) {  // ตรวจสอบดูว่าถ้ามีจุด  ( . )
        if ( tempspl[1].length  > limitcomma ) { // ตรวจสอบจำนวนทศนิยมเกินที่กำหนดหรือไม่ ( limitcomma )
            tempstr = tempspl[1].substring(0,limitcomma);
            obj.value = tempspl[0] + "." + tempstr;
        }
        if ( tempspl[0] == "") { // ตรวจสอบดูว่าค่าจำนวนเต็มกรอกแล้วหรือยัง
            obj.value = "0"+obj.value;
        }
    }
}

function callDelComma(obj) {
    obj.value = delComma(obj.value);
    obj.select();
}

function delComma(str) {
    var formatdelcomm = '' , checkcomma = 0;
    for (var i = str.length; i > 0; i--) {
        if (str.substring(i-1,i) != ",") formatdelcomm = str.substring(i-1,i) + formatdelcomm;
    }
    return formatdelcomm;
}
function chkEmail(obj) {
    if(obj.value!='')  {
        with(obj.value) {
            if(indexOf('@')  == 0 ) { alert("รูปแบบอีเมล์ไม่ถูกต้อง");   obj.select();  }
            else	if (indexOf('@')<0) { alert("รูปแบบอีเมล์ไม่ถูกต้อง");  obj.select(); 	}
            else	if (indexOf('@') != lastIndexOf('@')) { alert("รูปแบบอีเมล์ไม่ถูกต้อง");  obj.select(); 	}
            else	if (lastIndexOf('.') < lastIndexOf('@')) { alert("รูปแบบอีเมล์ไม่ถูกต้อง");  obj.select(); }
            else	if (lastIndexOf('.') > lastIndexOf('@') && (lastIndexOf('.')-lastIndexOf('@')) == 1) { alert("รูปแบบอีเมล์ไม่ถูกต้อง");  obj.select();  }
        }
    }
}
function goPage(link) {
    window.open(link , "help", "left=150,top=150,width=900,height=500,toolbar=no,status=no,scrollbars=yes");
}

function goClear() {
    with (document.form_data) {
        __cmd.value = "clear";
        submit();
    }
}

function goSearch() {
    with (document.form_data) {
        __cmd.value = "search";
        submit();
    }
}
function goSave() {
    if (!required()) {
        $('input[name=__cmd]').val("save");
        $('#form_data').submit();
    }
}
function goDelete() {
    with (document.form_data) {
        var delete_field = $('#__delete_field').val();
        if($('#'+delete_field).val().trim() !== '0') {
            if (confirm("ต้องการลบหรือไม่")) {
                __cmd.value = "delete";
                submit();
            }
        }else{
            alert('ไม่มีข้อมูล');
        }
    }
}

function required(){
    var is_require = false;
    var requires = $('#form_data input,textarea,select').filter('[required]:visible');
    $.each(requires,function(){
        var $this = $(this);
        if($this.val().trim() == ''){
            alert("กรุณากรอกข้อมูลให้ครบถ้วน");
            $this.focus();
            is_require = true;
            return false;
        }
    });

    return is_require;
}
function focusText(){
    document.getElementById('keyword').focus();
}


function deleteRow(message,page) {
    if(confirm(message)){
        window.location = page;
    }
}


