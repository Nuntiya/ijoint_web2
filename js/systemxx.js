function PchkRusult(a,b){

    if(b == true){
        document.getElementById('tbchk'+a).style.backgroundColor='#D4EDF8';
        document.getElementById('tcDetail'+a).disabled='';
        document.getElementById('qcStatus'+a).disabled='';
        document.getElementById('qaDefect'+a).disabled='';
    }else{
        document.getElementById('tbchk'+a).style.backgroundColor='#fff';
        document.getElementById('tcDetail'+a).value ='';
        document.getElementById('qcStatus'+a).value ='';
        document.getElementById('tcDetail'+a).disabled='disabled';
        document.getElementById('qcStatus'+a).disabled='disabled';
        document.getElementById('qaDefect'+a).disabled='disabled';
    }

}
function Presult(a,b){
    if(b =='P'){
        document.getElementById('tcDetail'+a).value = document.getElementById('tcNo'+a).innerHTML
    }else{
        document.getElementById('tcDetail'+a).value='';
        document.getElementById('tcDetail'+a).focus();
    }
}
function chkPTool(a){

    $.post("chkPcode.php",{
            PC: a
        },
        function(result){
            $('#posPTool').html(result);
        }
    );

}
function UserEst(a,b,c){
    $.post("userEstimate.php",{
            ESTname: a,
            ESTpos: b,
            ESTdate: c
        },
        function(result){
            $('#posEst').html(result);
        }
    );
}
function pgTestList(a,b,c,d){
    $.post("pgTestList.php",{
            FuncList: a,
            ConTest: b,
            DataTest: c,
            ExpTest: d
        },
        function(result){
            $('#posTest').html(result);
        }
    );
}
function pageActive(LPage){
    $("#posContain").load(LPage+'.php');
    $("#hdPage").val(LPage);
//            $.post("chkDefault.php",{
//                    PD: LPage
//                },
//                function(result){
//                }
//            );
}

/* Master Zone*/
function mnEstimate(e){
    $.post("Master/mnEstimate.php",{
            pModule: e,
            plang: $('#tLang').val(),
            preq:  $('#tTypeReq').val(),
            ptype: $('#tType').val(),
            parea: $('#tPArea').val(),
            pexam: $('#tPExam').val(),
            pcomplex: $('#tComplex').val(),
            pSA: $('#txtSA').val(),
            pPG: $('#txtPG').val(),
            pQC: $('#txtQC').val(),
            pQA: $('#txtQA').val()

        },
        function(result){
            $('#posMsEst').html(result);
        }
    );
}
function mnEstCost(e){
    alert('show');
    $.post("Master/mnEstCost.php",{
            pModule: e,
            plang: document.getElementById('tLang').value,
            pPosition: document.getElementById('tPosition').value,
            pCost: document.getElementById('tCost').value
        },
        function(result){
            $('#posMsEstCost').html(result);
        }
    );
}