<?php
session_start();
header("content-type: application/x-javascript");
// เงื่อนไขต่างๆ ที่จะดัก เช่น referer, cookie, session, captcha
if($_SESSION['QCUserCode']==''){
    Header("Location: ../404.php");
    die();
}
$chkAuthen = md5($_SESSION['QCUserCode']);
if ($_GET['csi'] == $chkAuthen ){
?>

<!--<script type="text/javascript">-->
    function loadProcess(){
            setTimeout(function(){ $('#bgBlockOpa').css('display','none') },1000);
    }
    function pageActive(LPage){
               $('#bgBlockOpa').css('display','block');
               $.post("chkDefault.php",{
                       PD: LPage
                   },
                   function(result){
                    $("#posContain").load(result);
                        $("#hdPage").val(result);
                        loadProcess();
                   }
               )


    }


    function remove_fileAttach(a,b){
        $.post("mainRFC/delAttach.php",{
            pStep: a,
            PD: b
        },
            function(result){
                $("#posBAttach").html(result);
            }
        );
    }
    function printRFC(a){
   // window.location="export/printRFCpage2.php?rid="+a;  target="_blank"; done=1;
    window.open('export/printRFCpage2.php?rid='+a,'_blank');
<!--        $.post("export/printRFCpage2.php",{-->
<!--            pReqID : a-->
<!--        },-->
<!--        function(result){-->
<!--            //PopupWin(result);-->
<!--               -->
<!--        }-->
<!--        );-->

    }

    function PopupWin(data)
    {
        var mywindow = window.open('', '', 'height=300,width=600');
        mywindow.document.write('<html><head><title>RFC</title>');
        /*optional stylesheet*/ //
       // mywindow.document.write('<link rel="stylesheet" type="text/css" href="css/tanaiCSS.css" />')
       // mywindow.document.write('<style type="text/css">table{font-family:tahoma;font-size:12px;}.txtnon{display:none;}.txtshow{display:block;}#pagePrintB2L{font-family:tahoma;font-size:12px;}</style>');
        mywindow.document.write('</head><body >');
        mywindow.document.write(data);
        mywindow.document.write('</body></html>');
        mywindow.print();
        mywindow.close();

    return true;
    }
    function chkFloatNum(sText,obj){
        var ValidChars = "0123456789.";
        var IsNumber=true;
        var Char;
        for (i = 0; i <= sText.length && IsNumber == true; i++) {
            Char = sText.charAt(i);

            if (ValidChars.indexOf(Char) == -1) {
                    IsNumber = false;
            }
            if(IsNumber==false){
                alert("พิมพ์ได้เฉพาะตัวเลขเท่านั้น");
                obj.value='';
            }
        }

    }
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
        function skipByComp(comp){
            $.post("mainRFC/newStepByComp.php",{
                Pcomp: comp
            },
            function(result){
                $('#tPosProject').html(result);
            }
    );
        }
        function proActive(code){
                $('#txtPcode').val(code);

                $.post("baseActive.php",{
                    pCode: code,
                    stepACL: $('#stepACL').val(),
                    stepAC: $('#stepAC').val(),
                },
                    function(result){
                    $('#PosAc').html(result);
                    }
                 );

                $.post("pmActiveCI.php",{
                    pCode: code
                },
                function(result){
                 $('#setTeam').html(result);

                }
                );

                $.post("mainRFC/maxRFCbyPcode.php",{
                        pCode: code
                    },
                    function(result){
                        $('#pmAddValue').html(result);

                    }
                );
        }

        function UserEst(a,b){
            var checkPass = true;
            var startEst = '';
            if($('#tlang').val()==''){ checkPass = false; }
            if($('#ttypereq').val()==''){ checkPass = false; }
            if($('#tComplex').val()==''){ checkPass = false; }
            if($('#estUserID').val()==''){ checkPass = false; }
            if($('#estRoleID').val()==''){ checkPass = false; }
                    if(checkPass==true){
                        $.post("mainRFC/pmCheckDate.php",{
                                pChkDate: $('#startEst').val(),
                                pSTDate: $('#targetStart').val(),
                                pFINdate: $('#targetFin').val()
                            },
                            function(result){
                                if(result==''){
                                    startEst = $('#startEst').val();
                                    var roleU =  $('#estRoleID').val();
                                    $.post("userEstimate.php",{
                                        pModule: a,                     // Add / Edit /Del
                                        pThis: b,                       //request_id rfc
                                        ESTool: $('#tlang').val(),
                                        ESType: $('#ttypereq').val(),
                                        ESTLevel: $('#tComplex').val(),
                                        ESTname: $('#estUserID').val(),
                                        ESTpos: roleU,
                                        ESTdate: $('#startEst').val(),
                                        ESTTypeFunc: $('input[name=estType]:checked').val(),
                                        ESTFunc_no: $('#EstFunc_no').val(),
                                        EstHourFunc: $('#EstHourFunc').val(),
                                        ESTCostFunc: $('#EstCostFunc').val()
                                    },
                                    function(result){
                                        $('#posEst').html(result);
                                        if(roleU=='SA' || roleU=='PG' || roleU=='CI'){  $('#tChkESCI').val('1'); }
                                        if(roleU=='QC'){  $('#tChkESQC').val('1'); }
                                        if(roleU=='QA'){  $('#tChkESQA').val('1'); }

                                    }
                                    );
                                }else{
                                    $('#startEst').val('')
                                    startEst = '';
                                    //alert(checkPass);
                                    alert(result);
                                }
                            }
                        );
                }else{
                    alert("กรุณากรอกข้อมูลให้เรียบร้อย");
                }

                if(a=='Del'){

                    $.post("userEstimate.php",{
                                        pModule: a,                     // Add / Edit /Del
                                        pThis: b,                       //request_id rfc
                                        ESTool: $('#tlang').val(),
                                        ESType: $('#ttypereq').val(),
                                        ESTLevel: $('#tComplex').val(),
                                        ESTname: $('#estUserID').val(),
                                        ESTpos: $('#estRoleID').val(),
                                        ESTdate: $('#startEst').val(),
                                        ESTTypeFunc: $('input[name=estType]:checked').val(),
                                        ESTFunc_no: $('#EstFunc_no').val(),
                                        EstHourFunc: $('#EstHourFunc').val(),
                                        ESTCostFunc: $('#EstCostFunc').val()
                                    },
                                    function(result){
                                        $('#posEst').html(result);
                                    }
                                );
                }
        }

        function chgLTopos(a){
            $.post("mainRFC/chgLangToPos.php",{
                    pos: a
                },
                function(result){
                    $('#langPos').html(result);
                }
            );
        }
    function chgLToProblem(a){
        $.post("mainRFC/problemToPos.php",{
            pos: a,
            ptypeRe: $('#ttypereq').val(),
            problem: $('#tproblem').val()
        },
        function(result){
            $('#posProblem').html(result);
        }
        );
    }
    function posToUser(a){
        $.post("mainRFC/chgPosToUser.php",{
                pos: a,
                pcode: $('#txtPcode').val()
            },
            function(result){
                $('#userPos').html(result);
            }
        );
    }

        function pgClearFrm(){
            $('#tfuncList').val('');
            $('#tConTest').val('');
            $('#tDataTest').val('');
            $('#tExpTest').val('');
        }
        function pgTestList(a,b){
            $.post("pgTestList.php",{
                    pModule: a,
                    pThis: b,  //reid
                    FuncList: $('#tfuncList').val(),
                    ConTest: $('#tConTest').val(),
                    DataTest: $('#tDataTest').val(),
                    ExpTest: $('#tExpTest').val()
                },
                function(result){
                    $('#posTest').html(result);
                     pgClearFrm();
                }
            );
        }

        function pgSaveTest(a,b){
                $.post("mainRFC/pgSaveTest.php",{
                    pModule: a,
                    pThis: b,
                    tPcode: $('#Cpcode').val(),
                    tTestCaseNo: $('#Ctestcase').val(),
                    tRunID: $('#CRunID').val(),
                    ttest_no: $('#Ctestcase').val(),
                    ttestType: $('input[name=rdoTestType]:checked').val(),
                    trequisite: $('#Crequis').val(),
                    ttestrunNo: $('#Ctestrun').val(),
                    treference_doc: $('#Cpreference').val(),
                    trevision: $('#CRevision').val()
                },
                function(result){
                   pageActive('newRFC.php?step=PG&id='+b);

                }
            );
        }

        /* Master Zone*/
   <? if($_SESSION['UserLevel']=='ADM' || $_SESSION['UserLevel']=='SADM'){ ?>
    function mnEstCost(e,f){
        var chkModule = false;
        if(e=='Del'){
            if(confirm("จะลบงานนี้จริงๆ หรือ ?")==true){ chkModule = true; }
        }
        if(e=='Add'){
            chkModule = CostChkData();
        }
        if(e=='Edit'){chkModule = true;}
        if(chkModule==true){
            $.post("Master/estCostList.php",{
                    pModule: e,
                    pThis: f,
                    plang: $('#tLang').val(),
                    pPosition: $('#tPosition').val(),
                    pCost: $('#tCost').val()
                },
                function(result){
                    $('#posMsEstCost').html(result);
                    $('button#BoxClose').trigger('click');
                }
            );
        }
    }
    function estCostEdit(a){
        $.post("Master/estCostEdit.php",{
            pThis: a
        },
            function(result){
                $('#pAdd').html(result);
            }
        );

    }

    function estCostFrm(){
        $.post("Master/estCostFrm.php",
            function(result){
                $('#pAdd').html(result);
            }
        );
    }
        function mEdit(a,b){
        $.post("Master/chkMain.php",{
            pThis: a
        },
            function(result){
                $('#pE').html(result);
            }
        );

        }
    function CostChkData(){
    if($('#tLang').val()=='' || $('#tPosition').val()=='' || $('#tCost').val()==''){
        if($('#tLang').val()==''){
            $('#tLang').css("border", "solid thin #ED0000");
        }else{ $('#tLang').css("border", "solid thin #d2d6de"); }
        if($('#tPosition').val()==''){
            $('#tPosition').css("border", "solid thin #ED0000");
        }else{ $('#tPosition').css("border", "solid thin #d2d6de"); }
        if($('#tCost').val()==''){
            $('#tCost').css("border", "solid thin #ED0000");
        }else{ $('#tCost').css("border", "solid thin #d2d6de"); }

        return false;
    }else{
        $('input,select,textarea').css("border", "solid thin #d2d6de");
        return true;
    }
    }
    <!--    Estimate Start-->
        function EstChkData(){
            if($('#tLang').val()=='' || $('#tTypeReq').val()=='' || $('#tComplex').val()=='' || $('#txtSA').val()==''  || $('#txtPG').val()=='' || $('#txtQC').val()=='' || $('#txtQA').val()=='' ){
                if($('#tLang').val()==''){
                    $('#tLang').css("border", "solid thin #ED0000");
                }else{ $('#tLang').css("border", "solid thin #d2d6de"); }
                if($('#tTypeReq').val()==''){
                    $('#tTypeReq').css("border", "solid thin #ED0000");
                }else{ $('#tTypeReq').css("border", "solid thin #d2d6de"); }
                if($('#tComplex').val()==''){
                    $('#tComplex').css("border", "solid thin #ED0000");
                }else{ $('#tComplex').css("border", "solid thin #d2d6de"); }
                if($('#txtSA').val()==''){
                    $('#txtSA').css("border", "solid thin #ED0000");
                }else{ $('#txtSA').css("border", "solid thin #d2d6de"); }
                if($('#txtPG').val()==''){
                    $('#txtPG').css("border", "solid thin #ED0000");
                }else{ $('#txtPG').css("border", "solid thin #d2d6de"); }
                if($('#txtQC').val()==''){
                    $('#txtQC').css("border", "solid thin #ED0000");
                }else{ $('#txtQC').css("border", "solid thin #d2d6de"); }
                if($('#txtQA').val()==''){
                    $('#txtQA').css("border", "solid thin #ED0000");
                }else{ $('#txtQA').css("border", "solid thin #d2d6de"); }
                return false;
            }else{
                $('input,select,textarea').css("border", "solid thin #d2d6de");
                return true;
            }

        }
        function mnEstimate(e,f1,f2,f3){
            var chkModule = false;
            if(e=='Del'){
                if(confirm("จะลบงานนี้จริงๆ หรือ ?")==true){ chkModule = true; }
            }
            if(e=='Add'){
                chkModule = EstChkData();

            }
            if(e=='Edit'){chkModule = true;}
            if(chkModule==true){
                $.post("Master/estimateList.php",{
                        pModule: e,
                        pThisH: f1,
                        pThisM: f2,
                        pThisL: f3,
                        plang: $('#tLang').val(),
                        preq:  $('#tTypeReq').val(),
                        ptype: $('#tType').val(),
                        parea: $('#tPArea').val(),
                        pexam: $('#tPExam').val(),
                        pcomplex: $('#tComplex').val(),
                        pHSA: $('#HtxtSA').val(),
                        pHPG: $('#HtxtPG').val(),
                        pHQC: $('#HtxtQC').val(),
                        pHQA: $('#HtxtQA').val(),
                        pMSA: $('#MtxtSA').val(),
                        pMPG: $('#MtxtPG').val(),
                        pMQC: $('#MtxtQC').val(),
                        pMQA: $('#MtxtQA').val(),
                        pLSA: $('#LtxtSA').val(),
                        pLPG: $('#LtxtPG').val(),
                        pLQC: $('#LtxtQC').val(),
                        pLQA: $('#LtxtQA').val()

                    },
                    function(result){
                        $('#posMsEst').html(result);
                        $('button#BoxClose').trigger('click');
                    }
                );
            }
        }




        function mnEditEst(a,b,c){
            $.post("Master/estimateEdit.php",{
                    pThisH: a,
                    pThisM: c,
                    pThisL: b
                },
                function(result){
                    $('#pAdd').html(result);
                }
            );

        }

    function mnFrmEst(){
        $.post("Master/estimateFrm.php",
            function(result){
                $('#pAdd').html(result);
            }
        );

    }

    /** End Estimate ****/

/** Start Role DATA  ****/
function roleChkData(){
    if($('#trRole').val()=='' || $('#trName').val()=='' ){
        if($('#trRole').val()==''){
            $('#trRole').css("border", "solid thin #ED0000");
        }else{ $('#trRole').css("border", "solid thin #d2d6de"); }
        if($('#trName').val()==''){
            $('#trName').css("border", "solid thin #ED0000");
        }else{ $('#trName').css("border", "solid thin #d2d6de"); }

        return false;
    }else{
        $('input,select,textarea').css("border", "solid thin #d2d6de");
        return true;
    }

}
    function roleAction(e,f){

    var chkModule = false;
    if(e=='Del'){
        if(confirm("จะลบงานนี้จริงๆ หรือ ?")==true){ chkModule = true; }
    }
    if(e=='Add'){
        chkModule = roleChkData();
        //chkModule = true;
    }
    if(e=='Edit'){chkModule = true;}
        if(chkModule==true){
            $.post("Master/roleList.php",{
                pModule: e,
                pThis: f,
               // ptpid: $('#hpId').val(),
                ptpRole: $('#trRole').val(),
                ptpName:  $('#trName').val(),
                ptpDescript: $('#trDescript').val()
            },
            function(result){
                $('#posRole').html(result);
                $('button#BoxClose').trigger('click');
            }
            );
        }
    }
    function roleList(a){
        $.post("Master/roleList.php",{
            chpid: a
        },function(result){
            $('#posRole').html(result);
        }
        );

    }
    function roleFrm(){
        $.post("Master/roleFrm.php",
            function(result){
                $('#pAdd').html(result);
            }
        );

    }

    function roleEdit(a){
        $.post("Master/roleEdit.php",{
             pThis: a
             //ptpid: $('#hpId').val()
        },
            function(result){
                $('#pAdd').html(result);
            }
        );
    }

    function roleSearch(){
        $('#posRoleM').css('display','none');
        $('#posSelectM').css('display','block');


        $.post("Master/roleSearch.php",{
                ptpid: $('#hpId').val()
        },
            function(result){
                $('#posSelectM').html(result);
                $('#pAdd').css('display','none');
            }
        );

    }

    function roleSelect(a,b){
        $('#pAdd').css('display','block');
        $('#tRid').val(a);
        $('#tRname').val(b);
        $('#posRoleM').css('display','block');
        $('#posSelectM').css('display','none');

    }
    /****End role ******/

    /** Start Role Member DATA   ****/

    function roleMemChkData(){
        if($('#tMuserID').val()=='' || $('#tRid').val()=='' ){
            if($('#tMuserID').val()==''){
                $('#tMuser').css("border", "solid thin #ED0000");
            }else{ $('#tMuser').css("border", "solid thin #d2d6de"); }
            if($('#tRid').val()==''){
                $('#tRname').css("border", "solid thin #ED0000");
            }else{ $('#tRname').css("border", "solid thin #d2d6de"); }

            return false;
        }else{
            $('input,select,textarea').css("border", "solid thin #d2d6de");
            return true;
        }

    }
    function roleMemberAction(e,f){

        var chkModule = false;
            if(e=='Del'){
                if(confirm("จะลบงานนี้จริงๆ หรือ ?")==true){ chkModule = true; }
            }
            if(e=='Add'){
                chkModule = roleMemChkData();
                //chkModule = true;
            }
        if(e=='Edit'){chkModule = true;}
        if(chkModule==true){
            $.post("Master/roleMemberList.php",{
                pModule: e,
                pThis: f,
                ptpcode: $('#tpCode').val(),
                ptpid: $('#hpId').val(),
                pUserID: $('#tMuserID').val(),
                pRid:  $('#tRid').val()
            },
                function(result){
                    $('#posRoleM').html(result);
                    //$('button#BoxClose').trigger('click');
                }
            );
        }
    }
    function roleMemberList(a){
        $.post("Master/roleMemberList.php",{
            chpid: a
            },function(result){
                $('#posRoleM').html(result);
            }
        );

    }
    function roleMemberFrm(){
        $('#posRoleM').css('display','block');
        $.post("Master/roleMemberFrm.php",
            function(result){
                $('#posRoleM').html(result);
            }
        );

    }

    function roleMemberEdit(a){
        $.post("Master/roleMemberEdit.php",{
                pThis: a,
                ptpid: $('#hpId').val()
            },
            function(result){
                $('#posRoleM').html(result);
            }
        );
    }

    function searchRoleMem(){
        $('#posSelectM').css('display','block');
        $('#pAdd').css('display','none');
            $.post("Master/roleMsSearch.php",{
                sName: $('#sUsername').val(),
                sCompany: $('#sCompany').val(),
                sDepartment: $('#sDepartment').val()
            }
            ,function(result){
                $('#posSelectM').html(result);
                $('#posRoleM').css('display','none');
            });
    }
    function roleMemSearch(){
        //$('#posRoleM').css('display','none');
        $('#posSelectM').css('display','block');
        $.post("Master/roleMemberSearch.php",
            function(result){
                $('#posSelectM').html(result);
                $('#pAdd').css('display','none');
            }
        );

    }

    function MemberSelect(a,b){
            $('#pAdd').css('display','block');
            $('#tMuserID').val(a);
            $('#tMuser').val(b);
            $('#posRoleM').css('display','block');
            $('#posSelectM').css('display','none');
    }
    function memToAddEdit(){
        $('#pAdd').css('display','block');
        $('#posRoleM').css('display','block');
        $('#posSelectM').css('display','none');
    }
    /****End role Member ******/

        /** Start Tool DATA  ****/
        function toolChkData(){
        if($('#trRole').val()=='' || $('#trName').val()=='' ){
        if($('#trRole').val()==''){
        $('#trRole').css("border", "solid thin #ED0000");
        }else{ $('#trRole').css("border", "solid thin #d2d6de"); }
        if($('#trName').val()==''){
        $('#trName').css("border", "solid thin #ED0000");
        }else{ $('#trName').css("border", "solid thin #d2d6de"); }

        return false;
        }else{
        $('input,select,textarea').css("border", "solid thin #d2d6de");
        return true;
        }

        }
        function toolAction(e,f){

        var chkModule = false;
        if(e=='Del'){
        if(confirm("จะลบงานนี้จริงๆ หรือ ?")==true){ chkModule = true; }
        }
        if(e=='Add'){
        chkModule = toolChkData();
        //chkModule = true;
        }
        if(e=='Edit'){chkModule = true;}
        if(chkModule==true){
        $.post("Master/toolList.php",{
        pModule: e,
        pThis: f,
        // ptpid: $('#hpId').val(),
        ptpRole: $('#trRole').val(),
        ptpName:  $('#trName').val(),
        ptpDescript: $('#trDescript').val()
        },
        function(result){
        $('#posRole').html(result);
        $('button#BoxClose').trigger('click');
        }
        );
        }
        }
        function toolList(a){
        $.post("Master/toolList.php",{
        chpid: a
        },function(result){
        $('#posRole').html(result);
        }
        );

        }
        function toolFrm(){
        $.post("Master/toolFrm.php",
        function(result){
        $('#pAdd').html(result);
        }
        );

        }

        function toolEdit(a){
        $.post("Master/toolEdit.php",{
        pThis: a
        //ptpid: $('#hpId').val()
        },
        function(result){
        $('#pAdd').html(result);
        }
        );
        }

        function toolSearch(){
        $('#posRoleM').css('display','none');
        $('#posSelectM').css('display','block');


        $.post("Master/toolSearch.php",{
        ptpid: $('#hpId').val()
        },
        function(result){
        $('#posSelectM').html(result);
        $('#pAdd').css('display','none');
        }
        );

        }

        function toolSelect(a,b){
        $('#pAdd').css('display','block');
        $('#tRid').val(a);
        $('#tRname').val(b);
        $('#posRoleM').css('display','block');
        $('#posSelectM').css('display','none');

        }
        /****End Tool ******/

    /** Start Project DATA  ****/

        function prjChkData(){
            if($('#tpCode').val()=='' || $('#tpName').val()=='' ){
                if($('#tpCode').val()==''){
                    $('#tpCode').css("border", "solid thin #ED0000");
                }else{ $('#tpCode').css("border", "solid thin #d2d6de"); }
                if($('#tpName').val()==''){
                    $('#tpName').css("border", "solid thin #ED0000");
                }else{ $('#tpName').css("border", "solid thin #d2d6de"); }

                return false;
            }else{
                $('input,select,textarea').css("border", "solid thin #d2d6de");
                return true;
            }

        }
    function stepConfig(e,f){
        //var $chkfixStep = $("input[name='chkfixStep[]'][type='checkbox']");
        var $chkStep = "";
        //$chkfixStep.each(function() {
        for($i=1;$i<=18;$i++){
            if($("#chk"+$i).is(':checked')){
                $val = 1;
                //alert('val='+$val);
            }else{
                $val = 2;
                //alert('val2='+$val);
            }

             $chkStep += $val + ",";
        //   $chkStep += $(this).val() + ",";
       // });
        }
        //alert($chkStep);
            $.post("Master/actionStep.php",{
                    pModule: e,
                    pThis: f,
                    ptpCode: $('#sCompany').val(),
                    ptpShort: $('#compShort').val(),
                    pChkStep : $chkStep
                },
                function(result){
                    alert("Save Success");
                //$('#posMsEst').html(result);
                $('button#BoxClose').trigger('click');
                }
            );
        }
        function viewStepConfig(a){
            $.post("Master/stepConfig.php",{
                    chpid: a
                },function(result){
                    $('#posConfig').html(result);
                }
            );

        }
    function ProjAction(e,f){

        var chkModule = false;
        if(e=='Del'){
            if(confirm("จะลบงานนี้จริงๆ หรือ ?")==true){ chkModule = true; }
        }
        if(e=='Add'){ chkModule = prjChkData(); }
        if(e=='Edit'){
            chkModule = true;

        }
        if(chkModule==true){
    var $myTeam = $("input[name='chkTeamM[]'][type='checkbox']:checked");
    var $team_meeting = "";
    $myTeam.each(function() {
    $team_meeting += $(this).val() + ",";
    });
    //alert($team_meeting);


    var $myWeek = $("input[name='chkWeek[]'][type='checkbox']:checked");
    var $TMW = "";
    $myWeek.each(function() {
    $TMW += $(this).val() + ",";
    });
    //alert($TMW);

    var $myReport = $("input[name='chkRTM[]'][type='checkbox']:checked");
    var $statusReport = "";
    $myReport.each(function() {
    $statusReport += $(this).val() + ",";
    });
    //alert($statusReport);


    var $myRWeek = $("input[name='chkRW[]'][type='checkbox']:checked");
    var $RW = "";
    $myRWeek.each(function() {
    $RW += $(this).val() + ",";
    });
    //alert($RW);
            $.post("Master/projectList.php",{
                pModule: e,
                pThis: f,
                ptpCode: $('#tpCode').val(),
                ptpName:  $('#tpName').val(),
                ptpType: $('#tpType').val(),
                ptpCompCode: $('#tpCompCode').val(),
                ptpsize: $('#tpsize').val(),
                ptpCustCode: $('#tpCustCode').val(),
                ptpOverview: $('#tpOverview').val(),
                ptpScope: $('#tpScope').val(),
                ptpObject: $('#tpObject').val(),
                ptpApproach: $('#tpApproach').val(),
                pTeam: $team_meeting,
                pTeamW: $TMW,
                pReport: $statusReport,
                pReportW: $RW,
                ptpStart: $('#tpStart').val(),
                ptpEnd: $('#tpEnd').val()
            },
                function(result){
                    $('#posMsEst').html(result);
                    $('button#BoxClose').trigger('click');
                }
            );
        }



    }

    function ProjectFrm(){
         $('#posFrm').html('');
        $('#pAdd').css("display","block");
        $('#posSelectM').css('display','none');
        $.post("Master/projectFrm.php",
            function(result){
                $('#posFrm').html(result);
                $('#noOpen').attr('data-toggle', 'no');
                $('#noOpen2').attr('data-toggle', 'no');
            }
        );

    }

    function projEdit(a){
        $('#posFrm').html('');
        $('#pAdd').css("display","block");
        $('#posSelectM').css('display','none');
        $('#hpId').val(a);
        $.post("Master/projectEdit.php",{
            pThis: a
        },
            function(result){
                $('#posFrm').html(result);
                $('#noOpen').attr('data-toggle', 'tab');
                $('#noOpen2').attr('data-toggle', 'tab');

            }
        );

        roleMemberList(a);

    }

        function compEdit(a,b){

            $.post("Master/stepConfig.php",{
                     pModule: a,
                     pThis: b
                },
                function(result){
                    $('#posConfig').html(result);
                }
            );
        //viewStepConfig(a);

        }

    /****End Project******/

    /** Start Type Request  ****/
    function typeChkData(){
        if($('#tpCode').val()=='' || $('#tpName').val()=='' ){
            if($('#tpCode').val()==''){
                $('#tpCode').css("border", "solid thin #ED0000");
            }else{ $('#tpCode').css("border", "solid thin #d2d6de"); }
            if($('#tpName').val()==''){
                $('#tpName').css("border", "solid thin #ED0000");
            }else{ $('#tpName').css("border", "solid thin #d2d6de"); }

            return false;
        }else{
            $('input,select,textarea').css("border", "solid thin #d2d6de");
            return true;
        }

    }
        function typeReqAction(e,f){
            var chkModule = false;
            if(e=='Del'){
                if(confirm("จะลบงานนี้จริงๆ หรือ ?")==true){ chkModule = true; }
            }
            if(e=='Add'){ chkModule = typeChkData(); }
            if(e=='Edit'){
                chkModule = true;

            }
            if(chkModule==true){
                $.post("Master/typeRequestList.php",{
                        pModule: e,
                        pThis: f,
                        ptCode: $('#tpCode').val(),
                        ptpName:  $('#tpName').val()
                    },
                    function(result){
                        $('#posMsEst').html(result);
                        $('button#BoxClose').trigger('click');
                    }
                );
            }



        }

        function typeReqFrm(){
            $.post("Master/typeRequestFrm.php",
                function(result){
                    $('#pAdd').html(result);
                }
            );

        }

        function typeReqEdit(a){

            $.post("Master/typeRequestEdit.php",{
                    pThis: a
                },
                function(result){
                    $('#pAdd').html(result);

                }
            );
        }

        /****End Type Request******/

        /** Start Role DATA  ****/
        function phaseChkData(){
            if($('#trPhase').val()=='' || $('#trName').val()=='' ){
                if($('#trPhase').val()==''){
                    $('#trPhase').css("border", "solid thin #ED0000");
                }else{ $('#trPhase').css("border", "solid thin #d2d6de"); }
                if($('#trName').val()==''){
                    $('#trName').css("border", "solid thin #ED0000");
                }else{ $('#trName').css("border", "solid thin #d2d6de"); }

                return false;
            }else{
                $('input,select,textarea').css("border", "solid thin #d2d6de");
                return true;
            }

        }
        function phaseAction(e,f){

            var chkModule = false;
            if(e=='Del'){
                if(confirm("จะลบงานนี้จริงๆ หรือ ?")==true){ chkModule = true; }
            }
            if(e=='Add'){
                chkModule = phaseChkData();
                //chkModule = true;
            }
            if(e=='Edit'){chkModule = true;}
            if(chkModule==true){
                $.post("Master/phaseList.php",{
                        pModule: e,
                        pThis: f,
                        ptpPhase: $('#trPhase').val(),
                        ptpName:  $('#trName').val(),
                        ptpDescript: $('#trDescript').val()
                    },
                    function(result){
                        $('#posPhase').html(result);
                        $('button#BoxClose').trigger('click');
                    }
                );
            }
        }
        function phaseList(a){
            $.post("Master/phaseList.php",{
                    chpid: a
                },function(result){
                    $('#posPhase').html(result);
                }
            );

        }
        function phaseFrm(){
            $.post("Master/phaseFrm.php",
                function(result){
                    $('#pAdd').html(result);
                }
            );

        }

        function phaseEdit(a){
            $.post("Master/phaseEdit.php",{
                    pThis: a
                    //ptpid: $('#hpId').val()
                },
                function(result){
                    $('#pAdd').html(result);
                }
            );
        }
//end phase
// company start @projectFrm_.php  @projectEdit_.php
function compSearch(){

    $('#posSelectM').css('display','block');
    $('#pAdd').css('display','none');

    $.post("Master/compSearch.php",
        function(result){
            $('#posSelectM').html(result);
            $('#pAdd').css('display','none');
        }
    );

}

function compSelect(a,b){
    $('#tpCompCode').val(a);
    $('#tpComp').val(b);

    $('#pAdd').css('display','block');
    $('#posSelectM').css('display','none');
}
//company end

// company start @projectFrm_.php  @projectEdit_.php

function custSearch(){
    $('#posSelectM').css('display','block');
    $('#pAdd').css('display','none');
    $.post("Master/custSearch.php",
        function(result){
            $('#posSelectM').css('display','block');
            $('#posSelectM').html(result);

        }
    );

}

function custSelect(a,b){
    $('#tpCustCode').val(a);
    $('#tpCustName').val(b);

    $('#pAdd').css('display','block');
    $('#posSelectM').css('display','none');
}
//company end

////////// masterUser=>user
/** Start Type Request  ****/
function userChkData(){
    if($('#tpCode').val()=='' || $('#tpName').val()=='' ){
        if($('#tpCode').val()==''){
            $('#tpCode').css("border", "solid thin #ED0000");
        }else{ $('#tpCode').css("border", "solid thin #d2d6de"); }
        if($('#tpName').val()==''){
            $('#tpName').css("border", "solid thin #ED0000");
        }else{ $('#tpName').css("border", "solid thin #d2d6de"); }

        return false;
    }else{
        $('input,select,textarea').css("border", "solid thin #d2d6de");
        return true;
    }

}
function userAction(e,f){
    var chkModule = false;
    if(e=='Del'){
        if(confirm("จะลบงานนี้จริงๆ หรือ ?")==true){ chkModule = true; }
    }
    if(e=='Add'){ chkModule = typeChkData(); }
    if(e=='Edit'){
        chkModule = true;

    }
    if(chkModule==true){
        $.post("masterUser/userList.php",{
                pModule: e,
                pThis: f,
                ptuCod: $('#tuCode').val(),
                ptuName:  $('#tuName').val(),
                ptuLevel:  $('input[name=tuLevel]:checked').val()
            },
            function(result){
                $('#posMsEst').html(result);
                $('button#BoxClose').trigger('click');
            }
        );
    }



}

function UserFrm(){  // ยังไม่เช็คว่าได้ใช้หรือเปล่า จำไม่ได้
    $.post("masterUser/userFrm.php",
        function(result){
            $('#pAdd').html(result);
        }
    );

}

function UserEdit(a){  // ยังไม่เช็คว่าได้ใช้หรือเปล่า จำไม่ได้

    $.post("masterUser/userEdit.php",{
            pThis: a
        },
        function(result){
            $('#pAdd').html(result);

        }
    );
}

/****End Type Request******/

/* User Master    */
function searchMsUser(){

    $('#posSelectM').css('display','block');
    $('#pAdd').css('display','none');

    $.post("masterUser/msUserSearch.php",{
            sName: $('#sUsername').val(),
            sCompany: $('#sCompany').val(),
            sDepartment: $('#sDepartment').val()
        }
        ,function(result){
            $('#posSelectM').html(result);
            $('#pAdd').css('display','none');
        }
    );
}
    //Step Submit Post
function msUserSearch(){

    $('#pAdd').css('display','none');
    $('#posSelectM').css('display','block');
    $.post("masterUser/msUserSearch.php",{
            sName: $('#tNname').val(),
            sDepartment: '<?=$_SESSION['DepartID'];?>',
            sCompany: '<?=$_SESSION['cCompCode'];?>'
        }
        ,function(result){
            $('#posSelectM').html(result);
        }
    );
}

    function msUserSelect(a,b,c){

        $('#pAdd').css('display','block');
        $('#posSelectM').css('display','none');
        $('#tuCode').val(a);
        $('#tuName').val(b);
    }
    //Step Submit Post

 <?  } ?>

//RFC zone
    // count rfcMyActivity
    function  menuCount(){
        $.post("mainRFC/menuCount.php",function(result){
        $('#CountMyAct').html(result);
    });
    }

    /**Step New RFC****/
    function fncNextStep(a,b,c){
        $('#tNuid').val(a);
        $('#tNname').val(b);
        $('#tnEmail').val(c);
    }
    /**End New RFC****/
    function newRFCSave(e,f,step){
        var chkModule = false;
        if(e=='Del'){
            if(confirm("จะลบงานนี้จริงๆ หรือ ?")==true){ chkModule = true; }
        }
        if(e=='Add'){
            if(step==0){ chkModule = reqDataNW();}
            if(step==1){ chkModule = reqDataED();}
            if(step==2){ chkModule = true;}
            if(step==3){ chkModule = reqDataPM();}
            if(step==4){ chkModule = reqDataCM();}
            if(step==5){ chkModule = true;}
            if(step==6){ chkModule = true;}
            if(step==7){ chkModule = reqDataSA();}
            if(step==8){ chkModule = reqDataPG();}
            if(step==9){ chkModule = reqDataQC();}
            if(step==10){ chkModule = reqDataQA();}
            if(step==11){ chkModule = true;}
            if(step==12){ chkModule = true;}
            if(step==13){ chkModule = true;}
            if(step==14){ chkModule = true;}
            if(step==15){ chkModule = true;}
        }
        if(e=='Edit'){
            chkModule = true;
        }
        if(chkModule==true){

            var varMail = $('#tnEmail').val();
            if(varMail==''?  varMail = '<?=$_SESSION['UserEmail'];?>': varMail );
            var varUid = $('#tNuid').val();
            if(varUid==''?  varUid = '<?=$_SESSION['QCUserCode'];?>':varUid );
            var varName = $('#tNname').val();
            if(varName==''?  varName = '<?=$_SESSION['UserName'];?>':varName );

            if(step==0){        // NW:New Request
                $('#bgBlockOpa').css('display','block');
                $.post("mainRFC/rfcSaveAction.php",{
                        pModule: e,
                        pThis: f,
                        nStep: step,
                        ptuserID: $('#tuserID').val(),
                        ptTel: $('#tTel').val(),
                        ptExpect: $('#tExpect').val(),
                        ptReqDetail: $('#tReqDetail').val(),
                        ptResonChg: $('#tResonChg').val(),
                        ptcPerson: $('#tcPerson').val(),
                        ptcCompCode: $('#tcCompcode').val(),
                        ptcCompany: $('#tcCompany').val(),
                        ptctpname: $('#tpname').val(),
                        ptcDepartment: $('#tcDepartment').val(),
                        ptcTel: $('#tcTel').val(),
                        ptcEmail: $('#tcEmail').val(),
                        tnEmail: varMail,    // Endorsement tnEmail
                        tNuid: varUid,        // Endorsement tNuid
                        tNname: varName      // Endorsement tNname
                    },
                    function(result){
                        //$('#checkdata').html(result);
                        loadProcess();
                        menuCount();
                        pageActive('rfcMyActivity.php');
                    }
                );
            }else if(step==1){   //  ED

                $.post("mainRFC/rfcSaveAction.php",{
                        pModule: e,
                        pThis: f,
                        nStep: step,
                        tReuid: $('#AppNewRe').val(),
                        //tReuid: $('#AppNewRe').val(),
                        tnEmail: varMail,    // Endorsement tnEmail
                        tNuid: varUid,        // Endorsement tNuid
                        tNname: varName      // Endorsement tNname
                    },
                    function(result){
                    //$('#checkdata').html(result);
                    loadProcess();
                    menuCount();
                    pageActive('rfcMyActivity.php');
                    }
                );
            }else if(step==2){  // SD
                $.post("mainRFC/rfcSaveAction.php",{
                        pModule: e,
                        pThis: f,
                        nStep: step,
                        tTicket: $('#txtTicket').val(),
                        tReuid: $('#ReAllStep').val(),
                        //tReuid: $('#AppEndors').val(),
                        tnEmail: varMail,    // Endorsement tnEmail
                        tNuid: varUid,        // Endorsement tNuid
                        tNname: varName      // Endorsement tNname
                    },
                    function(result){
                        $('#checkdata').html(result);
                        loadProcess();
                        menuCount();
                        pageActive('rfcMyActivity.php');
                    }
                );
            }else if(step==3){  //PM
                $.post("mainRFC/rfcSaveAction.php",{
                        pModule: e,
                        pThis: f,
                        nStep: step,
                        pRFC_No: $('#AppRFCNO').val(),
                        pPcode: $('#txtPcode').val(),
                        ptpname: $('#txtpname').val(),
                        ptprefix: $('#txtprefix').val(),
                        ptphase: $('#tphase').val(),
                        ptsystem: $('#tsystem').val(),
                        pttypereq: $('#ttypereq').val(),
                        ptlang: $('#tlang').val(),
                        ptComplex: $('#tComplex').val(),
                        ptargetStart: $('#targetStart').val(),
                        ptargetFin: $('#targetFin').val(),
                        ptestType: $('input[name=estType]:checked').val(),
                        tReuid: $('#ReAllStep').val(),
                        //tReuid: $('#AppSDRe').val(),
                        tnEmail: varMail,    // Endorsement tnEmail
                        tNuid: varUid,        // Endorsement tNuid
                        tNname: varName      // Endorsement tNname
                    },
                    function(result){
                        $('#checkdata').html(result);
                        loadProcess();
                        menuCount();
                        pageActive('rfcMyActivity.php');
                    }
                );
            }else if(step==4){  //CM
                //alert('show ='+e+f+step);
                $.post("mainRFC/rfcSaveAction.php",{
                        pModule: e,
                        pThis: f,
                        nStep: step,
                        ptimpGrp: $('#timpGrp').val(),
                        pchgAccept: $('input[name=chgAccept]:checked').val(),
                        ptimpact: $('#timpact').val(),
                        ptUrgency: $('#tUrgency').val(),
                        ptChangeType: $('input[name=tChangeType]:checked').val(), //$('#tChangeType').val(),
                        ptEmerChange: $('#tEmerChange').val(),
                        preasonEmer: $('#reasonEmer').val(),
                        pConfigImpact: $('#ConfigImpact').val(),
                        ptImpactFail: $('#tImpactFail').val(),
                        ptImpactUser: $('#tImpactUser').val(),
                        pcmBuild: $('input[name=cmBuild]:checked').val(),
                        pcmNote: $('#cmNote').val(),
                        tReuid: $('#ReAllStep').val(),
                        //tReuid: $('#AppPM').val(),
                        tnEmail: varMail,    // Endorsement tnEmail
                        tNuid: varUid,        // Endorsement tNuid
                        tNname: varName      // Endorsement tNname
                    },
                    function(result){
                        $('#checkdata').html(result);
                        loadProcess();
                        menuCount();
                        pageActive('rfcMyActivity.php');
                    }
                );
            }else if(step==5){    //Add Step CA ส่งชื่อ PM ไป
                $.post("mainRFC/rfcSaveAction.php",{
                        pModule: e,
                        pThis: f,
                        nStep: step,
                        pcaStatus: $('input[name=caStatus]:checked').val(),
                        ptCaNote: $('#tCaNote').val(),
                        tReuid: $('#AppPM').val(),
                        tnEmail: varMail,    // Endorsement tnEmail
                        tNuid: varUid,        // Endorsement tNuid
                        tNname: varName      // Endorsement tNname
                    },
                    function(result){
                        $('#checkdata').html(result);
                        loadProcess();
                        menuCount();
                        pageActive('rfcMyActivity.php');
                    }
                );
            }else if(step==6){    //Add Step CA2
                $.post("mainRFC/rfcSaveAction.php",{
                        pModule: e,
                        pThis: f,
                        nStep: step,
                        tReuid: $('#ReAllStep').val(),
                        //tReuid: $('#AppPM').val(),
                        tnEmail2: $('#tnEmail2').val(),    // Notify Mail CM
                        tNuid2: $('#tNuid2').val(),        // Notify tNuid CM
                        tNname2: $('#tNname2').val(),      // Notify tNname CM
                        tnEmail: varMail,    // Endorsement tnEmail
                        tNuid: varUid,        // Endorsement tNuid
                        tNname: varName      // Endorsement tNname
                    },
                    function(result){
                        $('#checkdata').html(result);
                        loadProcess();
                        menuCount();
                        pageActive('rfcMyActivity.php');
                    }
                );
            }else if(step==7){    //Add Step SA
                // alert('Add SA ต้องมีปุ่ม Revise หรือ ไม่ ??  ... ถ้ามี ต้อง Revise ไปยัง Step ไหน...  ตอนนี้ ส่งไปหา PM ชั่วคราว');
                $.post("mainRFC/rfcSaveAction.php",{
                        pModule: e,
                        pThis: f,
                        nStep: step,
                        ptImpGrp: $('#tImpGrp').val(),
                        ptImpPlan: $('input[name=tImpPlan]:checked').val(),  //$('#tImpPlan').val(),
                        ptBackOut: $('input[name=tBackOut]:checked').val(),  //$('#tBackOut').val(),
                        ptChgTest: $('input[name=tChgTest]:checked').val(),  //$('#tChgTest').val(),
                        ptCWstartSA: $('#tCWstartSA').val(),
                        ptCWfinishSA: $('#tCWfinishSA').val(),
                        ptCSStartSA: $('#tCSStartSA').val(),
                        ptCSFinSA: $('#tCSFinSA').val(),
                        ptConfChg: $('#tConfChg').val(),
                        ptFullDetail: $('#tFullDetail').val(),
                        ptProcImp: $('input[name=tProcImp]:checked').val(), //$('#tProcImp').val(),
                        ptNoteSA: $('#tNoteSA').val(),
                        peffHourSA: $('#effHourSA').val(),
                        peffMinuteSA: $('#effMinuteSA').val(),
                        tReuid: $('#ReAllStep').val(),
                        //tReuid: $('#AppPM').val(),
                        tnEmail: varMail,    // Endorsement tnEmail
                        tNuid: varUid,        // Endorsement tNuid
                        tNname: varName      // Endorsement tNname
                    },
                    function(result){
                        $('#checkdata').html(result);
                        loadProcess();
                        menuCount();
                        pageActive('rfcMyActivity.php');
                    }
                );
            }else if(step==8){    //Add Step PG
                $.post("mainRFC/rfcSaveAction.php",{
                        pModule: e,
                        pThis: f,
                        nStep: step,
                        ptCWstartPG: $('#tCWstartPG').val(),
                        ptCWfinishPG: $('#tCWfinishPG').val(),
                        ptCSStartPG: $('#tCSStartPG').val(),
                        ptCSFinPG: $('#tCSFinPG').val(),
                        ptNotePG: $('#notePG').val(),
                        PGhour: $('#effHourPG').val(),
                        PGminute: $('#effMinutePG').val(),
                        Ptype_review: $('#type_review').val(),
                        Ptestreview_no: $('#testreview_no').val(),
                        Preview_defect: $('#review_defect').val(),
                        Preview_item: $('#review_item').val(),
                        Ptestdefect_no: $('#testdefect_no').val(),
                        Ptypetest_defect: $('#typetest_defect').val(),
                        Ptest_defect: $('#test_defect').val(),
                        Ptest_item: $('#test_item').val(),
                        tReuid: $('#ReAllStep').val(),
                        //tReuid: $('#AppSA').val(),
                        tnEmail: varMail,    // Endorsement tnEmail
                        tNuid: varUid,        // Endorsement tNuid
                        tNname: varName      // Endorsement tNname
                    },
                    function(result){
                        $('#checkdata').html(result);
                        loadProcess();
                        menuCount();
                        pageActive('rfcMyActivity.php');
                    }
                );
            }else if(step==9){    //Add Step QC
                $.post("mainRFC/rfcSaveAction.php",{
                        pModule: e,
                        pThis: f,
                        nStep: step,
                        Ptype_review: $('#type_review').val(),
                        Ptestreview_no: $('#testreview_no').val(),
                        Preview_defect: $('#review_defect').val(),
                        Preview_item: $('#review_item').val(),
                        Ptestdefect_no: $('#testdefect_no').val(),
                        Ptypetest_defect: $('#typetest_defect').val(),
                        Ptest_defect: $('#test_defect').val(),
                        Ptest_item: $('#test_item').val(),
                        ptNotePG: $('#notePG').val(),
                        peffHourQC: $('#effHourQC').val(),      // ยังไม่ได้คำนวณ EFFORT
                        peffMinuteQC: $('#effMinuteQC').val(),  // ยังไม่ได้คำนวณ EFFORT
                        tReuid: $('#ReAllStep').val(),
                        //tReuid: $('#AppPG').val(),
                        tnEmail: varMail,    // Endorsement tnEmail
                        tNuid: varUid,        // Endorsement tNuid
                        tNname: varName      // Endorsement tNname
                    },
                    function(result){
                        $('#checkdata').html(result);
                        loadProcess();
                        menuCount();
                        pageActive('rfcMyActivity.php');
                    }
                );
            }else if(step==10){    //Add Step QA
                $.post("mainRFC/rfcSaveAction.php",{
                        pModule: e,
                        pThis: f,
                        nStep: step,
                        peffHourQA: $('#effHourQA').val(),      // ยังไม่ได้คำนวณ EFFORT
                        peffMinuteQA: $('#effMinuteQA').val(),  // ยังไม่ได้คำนวณ EFFORT
                        Ptype_review: $('#type_review').val(),
                        Ptestreview_no: $('#testreview_no').val(),
                        Preview_defect: $('#review_defect').val(),
                        Preview_item: $('#review_item').val(),
                        Ptestdefect_no: $('#testdefect_no').val(),
                        Ptypetest_defect: $('#typetest_defect').val(),
                        Ptest_defect: $('#test_defect').val(),
                        Ptest_item: $('#test_item').val(),
                        ptNotePG: $('#notePG').val(),
                        tReuid: $('#ReAllStep').val(),
                        //tReuid: $('#AppQC').val(),
                        tnEmail1: $('#tnEmail1').val(),
                        tnEmail2: $('#tnEmail2').val(),
                        tNuid1: $('#tNuid1').val(),
                        tNuid2: $('#tNuid2').val(),
                        tnEmail: varMail,    // Endorsement tnEmail
                        tNuid: varUid,        // Endorsement tNuid
                        tNname: varName      // Endorsement tNname
                    },
                    function(result){
                        $('#checkdata').html(result);
                        loadProcess();
                        menuCount();
                        pageActive('rfcMyActivity.php');
                    }
                );
            }else if(step==11){    //Add Step CD
                $.post("mainRFC/rfcSaveAction.php",{
                        pModule: e,
                        pThis: f,
                        nStep: step,
                        ptcdStatus: $('#tcdStatus').val(),
                        ptcdNote: $('#tcdNote').val(),
                        ptcdDefact: $('#tcdDefact').val(),
                        tReuid: $('#ReAllStep').val(),
                        //tReuid: $('#AppSA').val(),
                        tnEmail: varMail,    // Endorsement tnEmail
                        tNuid: varUid,        // Endorsement tNuid
                        tNname: varName      // Endorsement tNname
                    },
                    function(result){
                        $('#checkdata').html(result);
                        loadProcess();
                        menuCount();
                        pageActive('rfcMyActivity.php');
                    }
                );
            }else if(step==12){    //Add Step CD2
                $.post("mainRFC/rfcSaveAction.php",{
                        pModule: e,
                        pThis: f,
                        nStep: step,
                        tReuid: $('#ReAllStep').val(),
                        //tReuid: $('#AppSA').val(),
                        tnEmail2: $('#tnEmail2').val(),
                        tNuid2: $('#tNuid2').val(),
                        tNname2: $('#tNname2').val(),
                        tnEmail: varMail,    // Endorsement tnEmail
                        tNuid: varUid,        // Endorsement tNuid
                        tNname: varName      // Endorsement tNname
                    },
                    function(result){
                        $('#checkdata').html(result);
                        loadProcess();
                        menuCount();
                        pageActive('rfcMyActivity.php');
                    }
                );
            }else if(step==13){    //Add Step CC
                $.post("mainRFC/rfcSaveAction.php",{
                        pModule: e,
                        pThis: f,
                        nStep: step,
                        ptccChgStatus: $('#tccChgStatus').val(),
                        ptccReason: $('#tccReason').val(),
                        ptccTotalDur: $('#tccTotalDur').val(),
                        ptccEffort: $('#tccEffort').val(),
                        ptccNote: $('#tccNote').val(),
                        ptccProConfig: $('#tccProConfig').val(),
                        tReuid: $('#ReAllStep').val(),
                        //tReuid: $('#AppPM').val(),
                        tnEmail: varMail,    // Endorsement tnEmail
                        tNuid: varUid,        // Endorsement tNuid
                        tNname: varName      // Endorsement tNname
                    },
                    function(result){
                        $('#checkdata').html(result);
                        loadProcess();
                        menuCount();
                        pageActive('rfcMyActivity.php');

                    }
                );
            }else if(step==14){    //Add Step CC2
                $.post("mainRFC/rfcSaveAction.php",{
                        pModule: e,
                        pThis: f,
                        nStep: step,
                        tReuid: $('#ReAllStep').val(),
                        //tReuid: $('#AppPM').val(),
                        tnEmail: varMail,    // Endorsement tnEmail
                        tNuid: varUid,        // Endorsement tNuid
                        tNname: varName      // Endorsement tNname
                    },
                    function(result){
                        $('#checkdata').html(result);
                        loadProcess();
                        menuCount();
                        pageActive('rfcMyActivity.php');
                    }
                );
            }else if(step==15){    //Add Step CC3
                $.post("mainRFC/rfcSaveAction.php",{
                        pModule: e,
                        pThis: f,
                        nStep: step,
                        tReuid: $('#ReAllStep').val(),
                        //tReuid: $('#AppPM').val(),
                        tNuid2: $('#tNuid2').val(),
                        tnEmail2: $('#tnEmail2').val(),
                        tnEmail: varMail,    // Endorsement tnEmail
                        tNuid: varUid,        // Endorsement tNuid
                        tNname: varName      // Endorsement tNname
                    },
                    function(result){
                        $('#checkdata').html(result);
                        loadProcess();
                        menuCount();
                        pageActive('rfcMyActivity.php');
                    }
                );
            }


        }



    }


    function newRFCSaveOLD(e,f,step){  // ไม่ได้ใช้แล้ว backup ไว้เผื่อมีปัญหา

        var chkModule = false;
        if(e=='Del'){
            if(confirm("จะลบงานนี้จริงๆ หรือ ?")==true){ chkModule = true; }
        }
        if(e=='Add'){ chkModule = true ;
            //alert('check add ok');
            // typeChkData();
        }
        if(e=='Edit'){
            chkModule = true;
        }
        if(chkModule==true){
            // varMail  varUid varName
            var varMail = $('#tnEmail').val();
            if(varMail==''?  varMail = '<?=$_SESSION['UserEmail'];?>': varMail );
            var varUid = $('#tNuid').val();
            if(varUid==''?  varUid = '<?=$_SESSION['QCUserCode'];?>':varUid );
            var varName = $('#tNname').val();
            if(varName==''?  varName = '<?=$_SESSION['UserName'];?>':varName );

            if(step=='NW'){
                $.post("mainRFC/rfcSaveAction.php",{
                        pModule: e,
                        pThis: f,
                        nStep: step,
                        ptuserID: $('#tuserID').val(),
                        ptTel: $('#tTel').val(),
                        ptExpect: $('#tExpect').val(),
                        ptReqDetail: $('#tReqDetail').val(),
                        ptResonChg: $('#tResonChg').val(),
                        ptcPerson: $('#tcPerson').val(),
                        ptcCompCode: $('#tcCompcode').val(),
                        ptcCompany: $('#tcCompany').val(),
                        ptcDepartment: $('#tcDepartment').val(),
                        ptcTel: $('#tcTel').val(),
                        ptcEmail: $('#tcEmail').val(),
                        tnEmail: varMail,    // Endorsement tnEmail
                        tNuid: varUid,        // Endorsement tNuid
                        tNname: varName      // Endorsement tNname
                    },
                    function(result){
                        $('#checkdata').html(result);
                    }
                );
            }else if(step=='ED'){    //Endorsement
                $.post("mainRFC/rfcSaveAction.php",{
                        pModule: e,
                        pThis: f,
                        nStep: step,
                        tnEmail: varMail,    // Endorsement tnEmail
                        tNuid: varUid,        // Endorsement tNuid
                        tNname: varName      // Endorsement tNname
                    },
                    function(result){
                        $('#checkdata').html(result);
                    }
                );
            }else if(step=='SD'){   //Service Desk
                $.post("mainRFC/rfcSaveAction.php",{
                        pModule: e,
                        pThis: f,
                        nStep: step,
                        tTicket: $('#txtTicket').val(),
                        tnEmail: varMail,    // Endorsement tnEmail
                        tNuid: varUid,        // Endorsement tNuid
                        tNname: varName      // Endorsement tNname
                    },
                    function(result){
                        $('#checkdata').html(result);
                    }
                );
            }else if(step=='PM'){  //PM
                $.post("mainRFC/rfcSaveAction.php",{
                        pModule: e,
                        pThis: f,
                        nStep: step,
                        pRFC_No: $('#txtRFC_No').val(),
                        pPcode: $('#txtPcode').val(),
                        ptpname: $('#tpname').val(),
                        ptphase: $('#tphase').val(),
                        ptsystem: $('#tsystem').val(),
                        pttypereq: $('#ttypereq').val(),
                        ptlang: $('#tlang').val(),
                        ptComplex: $('#tComplex').val(),
                        ptargetStart: $('#targetStart').val(),
                        ptargetFin: $('#targetFin').val(),
                        ptestType: $('input[name=estType]:checked').val(),
                        tnEmail: varMail,    // Endorsement tnEmail
                        tNuid: varUid,        // Endorsement tNuid
                        tNname: varName      // Endorsement tNname
                    },
                    function(result){
                        $('#checkdata').html(result);
                    }
                );
            }else if(step=='CM'){  //CM
                $.post("mainRFC/rfcSaveAction.php",{
                        pModule: e,
                        pThis: f,
                        nStep: step,
                        ptimpGrp: $('#timpGrp').val(),
                        pchgAccept: $('input[name=chgAccept]:checked').val(),
                        ptimpact: $('#timpact').val(),
                        ptUrgency: $('#tUrgency').val(),
                        ptChangeType: $('input[name=tChangeType]:checked').val(), //$('#tChangeType').val(),
                        ptEmerChange: $('#tEmerChange').val(),
                        preasonEmer: $('#reasonEmer').val(),
                        pConfigImpact: $('#ConfigImpact').val(),
                        ptImpactFail: $('#tImpactFail').val(),
                        ptImpactUser: $('#tImpactUser').val(),
                        pcmBuild: $('input[name=cmBuild]:checked').val(),
                        pcmNote: $('#cmNote').val(),
                        tnEmail: varMail,    // Endorsement tnEmail
                        tNuid: varUid,        // Endorsement tNuid
                        tNname: varName      // Endorsement tNname
                    },
                    function(result){
                        $('#checkdata').html(result);
                    }
                );
            }else if(step=='CA'){    //Add Step CA ส่งชื่อ PM ไป
                $.post("mainRFC/rfcSaveAction.php",{
                        pModule: e,
                        pThis: f,
                        nStep: step,
                        pcaStatus: $('input[name=caStatus]:checked').val(),
                        ptCaNote: $('#tCaNote').val(),
                        tnEmail: varMail,    // Endorsement tnEmail
                        tNuid: varUid,        // Endorsement tNuid
                        tNname: varName      // Endorsement tNname
                    },
                    function(result){
                        $('#checkdata').html(result);
                    }
                );
            }else if(step=='CA2'){    //Add Step CA2
                $.post("mainRFC/rfcSaveAction.php",{
                        pModule: e,
                        pThis: f,
                        nStep: step,
                        tnEmail2: $('#tnEmail2').val(),    // Notify Mail CM
                        tNuid2: $('#tNuid2').val(),        // Notify tNuid CM
                        tNname2: $('#tNname2').val(),      // Notify tNname CM
                        tnEmail: varMail,    // Endorsement tnEmail
                        tNuid: varUid,        // Endorsement tNuid
                        tNname: varName      // Endorsement tNname
                    },
                    function(result){
                        $('#checkdata').html(result);
                    }
                );
            }else if(step=='SA'){    //Add Step SA

                $.post("mainRFC/rfcSaveAction.php",{
                        pModule: e,
                        pThis: f,
                        nStep: step,
                        ptImpGrp: $('#tImpGrp').val(),
                        ptImpPlan: $('input[name=tImpPlan]:checked').val(), //$('#tImpPlan').val(),
                        ptBackOut: $('input[name=tBackOut]:checked').val(), //$('#tBackOut').val(),
                        ptChgTest: $('input[name=tChgTest]:checked').val(), //$('#tChgTest').val(),
                        ptCWstartSA: $('#tCWstartSA').val(),
                        ptCWfinishSA: $('#tCWfinishSA').val(),
                        ptCSStartSA: $('#tCSStartSA').val(),
                        ptCSFinSA: $('#tCSFinSA').val(),
                        ptConfChg: $('#tConfChg').val(),
                        ptFullDetail: $('#tFullDetail').val(),
                        ptProcImp: $('input[name=tProcImp]:checked').val(),   //$('#tProcImp').val(),
                        ptNoteSA: $('#tNoteSA').val(),
                        peffHourSA: $('#effHourSA').val(),      // ยังไม่ได้คำนวณ EFFORT
                        peffMinuteSA: $('#effMinuteSA').val(),  // ยังไม่ได้คำนวณ EFFORT
                        tnEmail: varMail,    // Endorsement tnEmail
                        tNuid: varUid,        // Endorsement tNuid
                        tNname: varName      // Endorsement tNname
                    },
                    function(result){
                        $('#checkdata').html(result);
                    }
                );
            }else if(step=='PG'){    //Add Step PG
                $.post("mainRFC/rfcSaveAction.php",{
                        pModule: e,
                        pThis: f,
                        nStep: step,
                        ptCWstartPG: $('#tCWstartPG').val(),
                        ptCWfinishPG: $('#tCWfinishPG').val(),
                        ptCSStartPG: $('#tCSStartPG').val(),
                        ptCSFinPG: $('#tCSFinPG').val(),
                        ptNotePG: $('#notePG').val(),
                        peffHourPG: $('#effHourPG').val(),      // ยังไม่ได้คำนวณ EFFORT
                        peffMinutePG: $('#effMinutePG').val(),  // ยังไม่ได้คำนวณ EFFORT
                        tnEmail: varMail,    // Endorsement tnEmail
                        tNuid: varUid,        // Endorsement tNuid
                        tNname: varName      // Endorsement tNname
                    },
                    function(result){
                        $('#checkdata').html(result);
                    }
                );
            }else if(step=='QC'){    //Add Step QC
                $.post("mainRFC/rfcSaveAction.php",{
                        pModule: e,
                        pThis: f,
                        nStep: step,
                        pQCidTC: $('#QCidTC').val(),
                        pQCresultTC: $('#QCresultTC').val(),
                        pQCidTR: $('#QCidTR').val(),
                        pQCresultTR: $('#QCresultTR').val(),
                        pQCDefact: $('#QCDefact').val(),
                        peffHourQC: $('#effHourQC').val(),      // ยังไม่ได้คำนวณ EFFORT
                        peffMinuteQC: $('#effMinuteQC').val(),  // ยังไม่ได้คำนวณ EFFORT
                        tnEmail: varMail,    // Endorsement tnEmail
                        tNuid: varUid,        // Endorsement tNuid
                        tNname: varName      // Endorsement tNname
                    },
                    function(result){
                        $('#checkdata').html(result);
                    }
                );
            }else if(step=='QA'){    //Add Step QA
                $.post("mainRFC/rfcSaveAction.php",{
                        pModule: e,
                        pThis: f,
                        nStep: step,
                        pQAidTC: $('#QAidTC').val(),
                        pQAresultTC: $('#QAresultTC').val(),
                        pQAidTR: $('#QAidTR').val(),
                        pQAresultTR: $('#QAresultTR').val(),
                        pQADefact: $('#QADefact').val(),
                        peffHourQA: $('#effHourQA').val(),      // ยังไม่ได้คำนวณ EFFORT
                        peffMinuteQA: $('#effMinuteQA').val(),  // ยังไม่ได้คำนวณ EFFORT
                        tnEmail1: $('#tnEmail1').val(),
                        tnEmail2: $('#tnEmail2').val(),
                        tNuid1: $('#tNuid1').val(),
                        tNuid2: $('#tNuid2').val(),
                        tnEmail: varMail,    // Endorsement tnEmail
                        tNuid: varUid,        // Endorsement tNuid
                        tNname: varName      // Endorsement tNname
                    },
                    function(result){
                        $('#checkdata').html(result);
                    }
                );
            }else if(step=='CD'){    //Add Step CD
                $.post("mainRFC/rfcSaveAction.php",{
                        pModule: e,
                        pThis: f,
                        nStep: step,
                        ptcdStatus: $('#tcdStatus').val(),
                        ptcdNote: $('#tcdNote').val(),
                        ptcdDefact: $('#tcdDefact').val(),
                        tnEmail: varMail,    // Endorsement tnEmail
                        tNuid: varUid,        // Endorsement tNuid
                        tNname: varName      // Endorsement tNname
                    },
                    function(result){
                        $('#checkdata').html(result);
                    }
                );
            }else if(step=='CD2'){    //Add Step CD2
                $.post("mainRFC/rfcSaveAction.php",{
                        pModule: e,
                        pThis: f,
                        nStep: step,
                        tnEmail2: $('#tnEmail2').val(),
                        tNuid2: $('#tNuid2').val(),
                        tNname2: $('#tNname2').val(),
                        tnEmail: varMail,    // Endorsement tnEmail
                        tNuid: varUid,        // Endorsement tNuid
                        tNname: varName      // Endorsement tNname
                    },
                    function(result){
                        $('#checkdata').html(result);
                    }
                );
            }else if(step=='CC'){    //Add Step CC
                $.post("mainRFC/rfcSaveAction.php",{
                        pModule: e,
                        pThis: f,
                        nStep: step,
                        ptccChgStatus: $('#tccChgStatus').val(),
                        ptccReason: $('#tccReason').val(),
                        ptccTotalDur: $('#tccTotalDur').val(),
                        ptccEffort: $('#tccEffort').val(),
                        ptccNote: $('#tccNote').val(),
                        ptccProConfig: $('#tccProConfig').val(),
                        tnEmail: varMail,    // Endorsement tnEmail
                        tNuid: varUid,        // Endorsement tNuid
                        tNname: varName      // Endorsement tNname
                    },
                    function(result){
                        $('#checkdata').html(result);
                    }
                );
            }else if(step=='CC2'){    //Add Step CC2
                $.post("mainRFC/rfcSaveAction.php",{
                        pModule: e,
                        pThis: f,
                        nStep: step,
                        tnEmail: varMail,    // Endorsement tnEmail
                        tNuid: varUid,        // Endorsement tNuid
                        tNname: varName      // Endorsement tNname
                    },
                    function(result){
                        $('#checkdata').html(result);
                    }
                );
            }else if(step=='CC3'){    //Add Step CC3
                $.post("mainRFC/rfcSaveAction.php",{
                        pModule: e,
                        pThis: f,
                        nStep: step,
                        tnEmail: varMail,    // Endorsement tnEmail
                        tNuid: varUid,        // Endorsement tNuid
                        tNname: varName      // Endorsement tNname
                    },
                    function(result){
                        $('#checkdata').html(result);
                    }
                );
            }
            // go to my RFC All status
            pageActive('rfcMyActivity.php');
        }

    }


    function reqDataNW(){
        if($('#tNname').val()=='' || $('#tReqDetail').val()=='' || $('#tResonChg').val()=='' || $('#tcCompcode').val()=='' ){
            if($('#tNname').val()==''){ $('#tNname').css("border", "solid thin #ED0000");  }else{ $('#tNname').css("border", "solid thin #d2d6de"); }
            if($('#tReqDetail').val()==''){ $('#tReqDetail').css("border", "solid thin #ED0000");  }else{ $('#tReqDetail').css("border", "solid thin #d2d6de"); }
            if($('#tResonChg').val()==''){ $('#tResonChg').css("border", "solid thin #ED0000");  }else{ $('#tResonChg').css("border", "solid thin #d2d6de"); }
            if($('#tcCompcode').val()==''){ $('#tcCompcode').css("border", "solid thin #ED0000");  }else{ $('#tcCompcode').css("border", "solid thin #d2d6de"); }
            return false;
        }else{
            $('input,select,textarea').css("border", "solid thin #d2d6de");
            return true;
        }

    }
    function reqDataED(){
        if($('#tNname').val()==''){
            if($('#tNname').val()==''){ $('#tNname').css("border", "solid thin #ED0000");  }else{ $('#tNname').css("border", "solid thin #d2d6de"); }
            return false;
        }else{
            $('input,select,textarea').css("border", "solid thin #d2d6de");
            return true;
        }
    }
    function reqDataSD(a){
    if(a=='chkN'){
        if($('#tNname').val()==''){ $('#tNname').css("border", "solid thin #ED0000"); return false;  }else{ $('#tNname').css("border", "solid thin #d2d6de");  }
    }
        if($('#txtTicket').val()==''){

            if($('#txtTicket').val()==''){ $('#txtTicket').css("border", "solid thin #ED0000");  }else{ $('#txtTicket').css("border", "solid thin #d2d6de"); }
            return false;
        }else{
            $('input,select,textarea').css("border", "solid thin #d2d6de");
            return true;
        }
    }
    function reqDataPM(a){
        if(a=='chkN'){
            if($('#tNname').val()==''){ $('#tNname').css("border", "solid thin #ED0000"); return false;  }else{ $('#tNname').css("border", "solid thin #d2d6de"); }
            if($('#txtPcode').val()=='' || $('#tsystem').val()=='' || $('#tlang').val()=='' || $('#ttypereq').val()=='' || $('#tChkESCI').val()=='' || $('#tChkESQC').val()=='' || $('#tChkESQA').val()==''){

                if($('#txtPcode').val()==''){ $('#tpname').css("border", "solid thin #ED0000");  }else{ $('#tpname').css("border", "solid thin #d2d6de"); }
                if($('#tsystem').val()==''){ $('#tsystem').css("border", "solid thin #ED0000");  }else{ $('#tsystem').css("border", "solid thin #d2d6de"); }
                if($('#tlang').val()==''){ $('#tlang').css("border", "solid thin #ED0000");  }else{ $('#tlang').css("border", "solid thin #d2d6de"); }
                if($('#ttypereq').val()==''){ $('#ttypereq').css("border", "solid thin #ED0000");  }else{ $('#ttypereq').css("border", "solid thin #d2d6de"); }
                if($('#tChkESCI').val()==''|| $('#tChkESQC').val()=='' || $('#tChkESQA').val()==''){ alert('Please Estimate Role CI QC QA'); }
                return false;
            }else{
                $('input,select,textarea').css("border", "solid thin #d2d6de");
                return true;
            }
        }else{
            return true;
        }


    }
    function reqDataCM(a){
    if(a=='chkN'){
        if($('#tNname').val()==''){ $('#tNname').css("border", "solid thin #ED0000"); return false;  }else{ $('#tNname').css("border", "solid thin #d2d6de"); }
    }
        if($('#timpGrp').val()=='' || $('#ConfigImpact').val()==''){

            if($('#timpGrp').val()==''){ $('#timpGrp').css("border", "solid thin #ED0000");  }else{ $('#timpGrp').css("border", "solid thin #d2d6de"); }
            if($('#ConfigImpact').val()==''){ $('#ConfigImpact').css("border", "solid thin #ED0000");  }else{ $('#ConfigImpact').css("border", "solid thin #d2d6de"); }
            return false;
        }else{
            $('input,select,textarea').css("border", "solid thin #d2d6de");
            return true;
        }

    }
    function reqDataSA(a){
    if(a=='chkN'){
        if($('#tNname').val()==''){ $('#tNname').css("border", "solid thin #ED0000"); return false;  }else{ $('#tNname').css("border", "solid thin #d2d6de"); }
    }
        if($('#tImpGrp').val()=='' || $('#tConfChg').val()=='' || $('#tFullDetail').val()==''|| $('#tCSStartSA').val()==''|| $('#tCSFinSA').val()==''|| $('#effHourSA').val()==''|| $('#effMinuteSA').val()==''){

            if($('#tImpGrp').val()==''){ $('#tImpGrp').css("border", "solid thin #ED0000");  }else{ $('#tImpGrp').css("border", "solid thin #d2d6de"); }
            if($('#tConfChg').val()==''){ $('#tConfChg').css("border", "solid thin #ED0000");  }else{ $('#tConfChg').css("border", "solid thin #d2d6de"); }
            if($('#tFullDetail').val()==''){ $('#tFullDetail').css("border", "solid thin #ED0000");  }else{ $('#tFullDetail').css("border", "solid thin #d2d6de"); }
            if($('#tCSStartSA').val()==''){ $('#tCSStartSA').css("border", "solid thin #ED0000");  }else{ $('#tCSStartSA').css("border", "solid thin #d2d6de"); }
            if($('#tCSFinSA').val()==''){ $('#tCSFinSA').css("border", "solid thin #ED0000");  }else{ $('#tCSFinSA').css("border", "solid thin #d2d6de"); }
            if($('#effHourSA').val()==''){ $('#effHourSA').css("border", "solid thin #ED0000");  }else{ $('#effHourSA').css("border", "solid thin #d2d6de"); }
            if($('#effMinuteSA').val()==''){ $('#effMinuteSA').css("border", "solid thin #ED0000");  }else{ $('#effMinuteSA').css("border", "solid thin #d2d6de"); }
            return false;
        }else{
            $('input,select,textarea').css("border", "solid thin #d2d6de");
            return true;
        }
    }
    function reqDataPG(a){
    if(a=='chkN'){
    if($('#tNname').val()==''){ $('#tNname').css("border", "solid thin #ED0000"); return false;  }else{ $('#tNname').css("border", "solid thin #d2d6de");  }
    }
        if($('#tCSStartPG').val()=='' || $('#tCSFinPG').val()=='' || $('#effHourPG').val()==''|| $('#effMinutePG').val()==''){

            if($('#tCSStartPG').val()==''){ $('#tCSStartPG').css("border", "solid thin #ED0000");  }else{ $('#tCSStartPG').css("border", "solid thin #d2d6de"); }
            if($('#tCSFinPG').val()==''){ $('#tCSFinPG').css("border", "solid thin #ED0000");  }else{ $('#tCSFinPG').css("border", "solid thin #d2d6de"); }
            if($('#effHourPG').val()==''){ $('#effHourPG').css("border", "solid thin #ED0000");  }else{ $('#effHourPG').css("border", "solid thin #d2d6de"); }
            if($('#effMinutePG').val()==''){ $('#effMinutePG').css("border", "solid thin #ED0000");  }else{ $('#effMinutePG').css("border", "solid thin #d2d6de"); }
            return false;
        }else{
            $('input,select,textarea').css("border", "solid thin #d2d6de");
            return true;
        }
    }
    function reqDataQC(a){
    if(a=='chkN'){
    if($('#tNname').val()==''){ $('#tNname').css("border", "solid thin #ED0000"); return false;  }else{ $('#tNname').css("border", "solid thin #d2d6de");  }
    }
        if($('#effHourQC').val()=='' || $('#effMinuteQC').val()=='' || $('#testreview_no').val()==''|| $('#review_item').val()==''|| $('#testdefect_no').val()==''|| $('#test_item').val()==''){

            if($('#effHourQC').val()==''){ $('#effHourQC').css("border", "solid thin #ED0000");  }else{ $('#effHourQC').css("border", "solid thin #d2d6de"); }
            if($('#effMinuteQC').val()==''){ $('#effMinuteQC').css("border", "solid thin #ED0000");  }else{ $('#effMinuteQC').css("border", "solid thin #d2d6de"); }
            if($('#testreview_no').val()==''){ $('#testreview_no').css("border", "solid thin #ED0000");  }else{ $('#testreview_no').css("border", "solid thin #d2d6de"); }
            if($('#review_item').val()==''){ $('#review_item').css("border", "solid thin #ED0000");  }else{ $('#review_item').css("border", "solid thin #d2d6de"); }
            if($('#testdefect_no').val()==''){ $('#testdefect_no').css("border", "solid thin #ED0000");  }else{ $('#testdefect_no').css("border", "solid thin #d2d6de"); }
            if($('#test_item').val()==''){ $('#test_item').css("border", "solid thin #ED0000");  }else{ $('#test_item').css("border", "solid thin #d2d6de"); }
            return false;
        }else{
            $('input,select,textarea').css("border", "solid thin #d2d6de");
            return true;
        }
    }
    function reqDataQA(a){
        if(a=='chkN'){
            if($('#tNname').val()==''){ $('#tNname').css("border", "solid thin #ED0000"); return false;  }else{ $('#tNname').css("border", "solid thin #d2d6de");  }
        }
        if($('#effHourQA').val()=='' || $('#effMinuteQA').val()=='' || $('#testreview_no').val()==''|| $('#review_item').val()==''|| $('#testdefect_no').val()==''|| $('#test_item').val()==''){

            if($('#effHourQA').val()==''){ $('#effHourQA').css("border", "solid thin #ED0000");  }else{ $('#effHourQA').css("border", "solid thin #d2d6de"); }
            if($('#effMinuteQA').val()==''){ $('#effMinuteQA').css("border", "solid thin #ED0000");  }else{ $('#effMinuteQA').css("border", "solid thin #d2d6de"); }
            if($('#testreview_no').val()==''){ $('#testreview_no').css("border", "solid thin #ED0000");  }else{ $('#testreview_no').css("border", "solid thin #d2d6de"); }
            if($('#review_item').val()==''){ $('#review_item').css("border", "solid thin #ED0000");  }else{ $('#review_item').css("border", "solid thin #d2d6de"); }
            if($('#testdefect_no').val()==''){ $('#testdefect_no').css("border", "solid thin #ED0000");  }else{ $('#testdefect_no').css("border", "solid thin #d2d6de"); }
            if($('#test_item').val()==''){ $('#test_item').css("border", "solid thin #ED0000");  }else{ $('#test_item').css("border", "solid thin #d2d6de"); }
            return false;
        }else{
            $('input,select,textarea').css("border", "solid thin #d2d6de");
            return true;
        }
    }

    function reqNoborder(a){
            $(a).css("border", "solid thin #d2d6de");
    }


function newRFCAction(e,f,step){

    var chkModule = false;
    if(e=='Del'){
        if(confirm("จะลบงานนี้จริงๆ หรือ ?")==true){ chkModule = true; }
    }
    if(e=='Add'){

        if(step==0){ chkModule = reqDataNW();}
        if(step==1){ chkModule = reqDataED();}
        if(step==2){ chkModule = reqDataSD('chkN');}
        if(step==3){ chkModule = reqDataPM('chkN');}
        if(step==4){ chkModule = reqDataCM('chkN');}
        if(step==5){ chkModule = true;}
        if(step==6){ chkModule = true;}
        if(step==7){ chkModule = reqDataSA('chkN');}
        if(step==8){ chkModule = reqDataPG('chkN');}
        if(step==9){ chkModule = reqDataQC('chkN');}
        if(step==10){ chkModule = reqDataQA('chkN');}
        if(step==11){ chkModule = true;}
        if(step==12){ chkModule = true;}
        if(step==13){ chkModule = true;}
        if(step==14){ chkModule = true;}
        if(step==15){ chkModule = true;}

    }

    if(e=='Revise'){ chkModule = true; }
    if(e=='Edit'){
        if(step==0){ chkModule = reqDataNW();}
        if(step==1){ chkModule = reqDataED();}
        if(step==2){ chkModule = reqDataSD('chkN');}
        if(step==3){ chkModule = reqDataPM('chkN');}
        if(step==4){ chkModule = reqDataCM('chkN');}
        if(step==5){ chkModule = true;}
        if(step==6){ chkModule = true;}
        if(step==7){ chkModule = reqDataSA('chkN');}
        if(step==8){ chkModule = reqDataPG('chkN');}
        if(step==9){ chkModule = reqDataQC('chkN');}
        if(step==10){ chkModule = reqDataQA('chkN');}
        if(step==11){ chkModule = true;}
        if(step==12){ chkModule = true;}
        if(step==13){ chkModule = true;}
        if(step==14){ chkModule = true;}
        if(step==15){ chkModule = true;}
    }
    if(chkModule==true){
    $('#bgBlockOpa').css('display','block');
        if(step==0){        // NW:New Request
            $.post("mainRFC/rfcAction.php",{
                        pModule: e,
                        pThis: f,
                        nStep: step,
                        ptuserID: $('#tuserID').val(),
                        ptTel: $('#tTel').val(),
                        ptExpect: $('#tExpect').val(),
                        ptReqDetail: $('#tReqDetail').val(),
                        ptResonChg: $('#tResonChg').val(),
                        ptcPerson: $('#tcPerson').val(),
                        ptcCompCode: $('#tcCompcode').val(),
                        ptcCompany: $('#tcCompany').val(),
                        ptctpname: $('#tpname').val(),
                        ptcDepartment: $('#tcDepartment').val(),
                        ptcTel: $('#tcTel').val(),
                        gticketNo: $('#gticketNo').val(),
                        grfcNo: $('#grfcNo').val(),
                        ptcEmail: $('#tcEmail').val(),
                        tnEmail: $('#tnEmail').val(),    // Endorsement tnEmail ใช้เหมือนกันทุก Step ใน text อาจใส่ Mailได้หลายmail เช่น Solos.T@samartcorp.com,Supinya.M@samartcorp.com,......
                        tNuid: $('#tNuid').val(),        // Endorsement tNuid
                        tNname: $('#tNname').val()      // Endorsement tNname
                    },
                    function(result){
                        $('#checkdata').html(result);
                        $('#btnUpAttach').click();
                        loadProcess();
                        menuCount();
                        pageActive('rfcMyActivity.php');
                    }
             );
        }else if(step==1){   //  ED
            $.post("mainRFC/rfcAction.php",{
                pModule: e,
                pThis: f,
                nStep: step,
                tReuid: $('#ReAllStep').val(),
                //tReuid: $('#AppNewRe').val(),
                gticketNo: $('#gticketNo').val(),
                grfcNo: $('#grfcNo').val(),
                tnEmail: $('#tnEmail').val(),    // Endorsement tnEmail ใช้เหมือนกันทุก Step ใน text อาจใส่ Mailได้หลายmail เช่น Solos.T@samartcorp.com,Supinya.M@samartcorp.com,......
                tNuid: $('#tNuid').val(),        // Endorsement tNuid
                tNname: $('#tNname').val()      // Endorsement tNname
            },
                function(result){
                    $('#checkdata').html(result);
                    loadProcess();
                    menuCount();
                    pageActive('rfcMyActivity.php');
                }
            );
        }else if(step==2){  // SD
            $.post("mainRFC/rfcAction.php",{
                    pModule: e,
                    pThis: f,
                    nStep: step,
                    tTicket: $('#txtTicket').val(),
                    tReuid: $('#ReAllStep').val(),
                    //tReuid: $('#AppEndors').val(),
                    gticketNo: $('#gticketNo').val(),
                    grfcNo: $('#grfcNo').val(),
                    tnEmail: $('#tnEmail').val(),    // Endorsement tnEmail ใช้เหมือนกันทุก Step ใน text อาจใส่ Mailได้หลายmail เช่น Solos.T@samartcorp.com,Supinya.M@samartcorp.com,......
                    tNuid: $('#tNuid').val(),        // Endorsement tNuid
                    tNname: $('#tNname').val()      // Endorsement tNname
                },
                function(result){
                    $('#checkdata').html(result);
                    loadProcess();
                    menuCount();
                    pageActive('rfcMyActivity.php');
                }
            );
        }else if(step==3){  //PM
            $.post("mainRFC/rfcAction.php",{
                    pModule: e,
                    pThis: f,
                    nStep: step,
                    pRFC_No: $('#AppRFCNO').val(),
                    pPcode: $('#txtPcode').val(),
                    ptpname: $('#txtpname').val(),
                    ptprefix: $('#txtprefix').val(),
                    ptphase: $('#tphase').val(),
                    ptsystem: $('#tsystem').val(),
                    pttypereq: $('#ttypereq').val(),
                    ptlang: $('#tlang').val(),
                    ptComplex: $('#tComplex').val(),
                    ptargetStart: $('#targetStart').val(),
                    ptargetFin: $('#targetFin').val(),
                    ptestType: $('input[name=estType]:checked').val(),
                    tReuid: $('#ReAllStep').val(),
                    //tReuid: $('#AppSDRe').val(),
                    gticketNo: $('#gticketNo').val(),
                    grfcNo: $('#grfcNo').val(),
                    tnEmail: $('#tnEmail').val(),    // Endorsement tnEmail ใช้เหมือนกันทุก Step ใน text อาจใส่ Mailได้หลายmail เช่น Solos.T@samartcorp.com,Supinya.M@samartcorp.com,......
                    tNuid: $('#tNuid').val(),        // Endorsement tNuid
                    tNname: $('#tNname').val()      // Endorsement tNname
                },
                function(result){
                    $('#checkdata').html(result);
                    $('#btnUpAttach').click();
                    loadProcess();
                    menuCount();
                    pageActive('rfcMyActivity.php');
                }
            );
        }else if(step==4){  //CM
        //alert('show ='+e+f+step);
        $.post("mainRFC/rfcAction.php",{
                pModule: e,
                pThis: f,
                nStep: step,
                ptimpGrp: $('#timpGrp').val(),
                pchgAccept: $('input[name=chgAccept]:checked').val(),
                ptimpact: $('#timpact').val(),
                ptUrgency: $('#tUrgency').val(),
                ptChangeType: $('input[name=tChangeType]:checked').val(), //$('#tChangeType').val(),
                ptEmerChange: $('#tEmerChange').val(),
                preasonEmer: $('#reasonEmer').val(),
                pConfigImpact: $('#ConfigImpact').val(),
                ptImpactFail: $('#tImpactFail').val(),
                ptImpactUser: $('#tImpactUser').val(),
                pcmBuild: $('input[name=cmBuild]:checked').val(),
                pcmNote: $('#cmNote').val(),
                tReuid: $('#ReAllStep').val(),
                //tReuid: $('#AppPM').val(),
                gticketNo: $('#gticketNo').val(),
                grfcNo: $('#grfcNo').val(),
                tnEmail: $('#tnEmail').val(),    // Endorsement tnEmail ใช้เหมือนกันทุก Step ใน text อาจใส่ Mailได้หลายmail เช่น Solos.T@samartcorp.com,Supinya.M@samartcorp.com,......
                tNuid: $('#tNuid').val(),        // Endorsement tNuid
                tNname: $('#tNname').val()      // Endorsement tNname
            },
            function(result){
                $('#checkdata').html(result);
                loadProcess();
                menuCount();
                pageActive('rfcMyActivity.php');
            }
        );
        }else if(step==5){    //Add Step CA ส่งชื่อ PM ไป
        $.post("mainRFC/rfcAction.php",{
                pModule: e,
                pThis: f,
                nStep: step,
                pcaStatus: $('input[name=caStatus]:checked').val(),
                ptCaNote: $('#tCaNote').val(),
                tReuid: $('#ReAllStep').val(),
                //tReuid: $('#AppCM').val(),
                gticketNo: $('#gticketNo').val(),
                grfcNo: $('#grfcNo').val(),
                tnEmail: $('#tnEmail').val(),    // Endorsement tnEmail ใช้เหมือนกันทุก Step ใน text อาจใส่ Mailได้หลายmail เช่น Solos.T@samartcorp.com,Supinya.M@samartcorp.com,......
                tNuid: $('#tNuid').val(),        // Endorsement tNuid
                tNname: $('#tNname').val()      // Endorsement tNname
            },
            function(result){
                $('#checkdata').html(result);
                loadProcess();
                menuCount();
                pageActive('rfcMyActivity.php');
            }
        );
    }else if(step==6){    //Add Step CA2
        $.post("mainRFC/rfcAction.php",{
                pModule: e,
                pThis: f,
                nStep: step,
                tReuid: $('#ReAllStep').val(),
                //tReuid: $('#AppCM').val(),
                gticketNo: $('#gticketNo').val(),
                grfcNo: $('#grfcNo').val(),
                tnEmail2: $('#tnEmail2').val(),    // Notify Mail CM
                tNuid2: $('#tNuid2').val(),        // Notify tNuid CM
                tNname2: $('#tNname2').val(),      // Notify tNname CM
                tnEmail: $('#tnEmail').val(),      //  Email SA
                tNuid: $('#tNuid').val(),          //  SA
                tNname: $('#tNname').val()         //  SA
            },
            function(result){
                $('#checkdata').html(result);
                loadProcess();
                menuCount();
                pageActive('rfcMyActivity.php');
            }
        );
    }else if(step==7){    //Add Step SA
           // alert('Add SA ต้องมีปุ่ม Revise หรือ ไม่ ??  ... ถ้ามี ต้อง Revise ไปยัง Step ไหน...  ตอนนี้ ส่งไปหา PM ชั่วคราว');
        $.post("mainRFC/rfcAction.php",{
                pModule: e,
                pThis: f,
                nStep: step,
                ptImpGrp: $('#tImpGrp').val(),
                ptImpPlan: $('input[name=tImpPlan]:checked').val(),  //$('#tImpPlan').val(),
                ptBackOut: $('input[name=tBackOut]:checked').val(), //$('#tBackOut').val(),
                ptChgTest: $('input[name=tChgTest]:checked').val(), //$('#tChgTest').val(),
                ptCWstartSA: $('#tCWstartSA').val(),
                ptCWfinishSA: $('#tCWfinishSA').val(),
                ptCSStartSA: $('#tCSStartSA').val(),
                ptCSFinSA: $('#tCSFinSA').val(),
                ptConfChg: $('#tConfChg').val(),
                ptFullDetail: $('#tFullDetail').val(),
                ptProcImp: $('input[name=tProcImp]:checked').val(),   //$('#tProcImp').val(),
                ptNoteSA: $('#tNoteSA').val(),
                peffHourSA: $('#effHourSA').val(),
                peffMinuteSA: $('#effMinuteSA').val(),
                tReuid: $('#ReAllStep').val(),
                //tReuid: $('#AppPM').val(),
                gticketNo: $('#gticketNo').val(),
                grfcNo: $('#grfcNo').val(),
                tnEmail: $('#tnEmail').val(),    // Endorsement tnEmail ใช้เหมือนกันทุก Step ใน text อาจใส่ Mailได้หลายmail เช่น Solos.T@samartcorp.com,Supinya.M@samartcorp.com,......
                tNuid: $('#tNuid').val(),        // Endorsement tNuid
                tNname: $('#tNname').val()      // Endorsement tNname
            },
            function(result){
                $('#checkdata').html(result);
                $('#btnUpAttach').click();
                loadProcess();
                menuCount();
                pageActive('rfcMyActivity.php');
            }
        );
    }else if(step==8){    //Add Step PG
        $.post("mainRFC/rfcAction.php",{
                pModule: e,
                pThis: f,
                nStep: step,
                ptCWstartPG: $('#tCWstartPG').val(),
                ptCWfinishPG: $('#tCWfinishPG').val(),
                ptCSStartPG: $('#tCSStartPG').val(),
                ptCSFinPG: $('#tCSFinPG').val(),
                ptNotePG: $('#notePG').val(),
                PGhour: $('#effHourPG').val(),
                PGminute: $('#effMinutePG').val(),
                Ptype_review: $('#type_review').val(),
                Ptestreview_no: $('#testreview_no').val(),
                Preview_defect: $('#review_defect').val(),
                Preview_item: $('#review_item').val(),
                Ptestdefect_no: $('#testdefect_no').val(),
                Ptypetest_defect: $('#typetest_defect').val(),
                Ptest_defect: $('#test_defect').val(),
                Ptest_item: $('#test_item').val(),
                tReuid: $('#ReAllStep').val(),
                //tReuid: $('#AppSA').val(),
                gticketNo: $('#gticketNo').val(),
                grfcNo: $('#grfcNo').val(),
                tnEmail: $('#tnEmail').val(),    // Endorsement tnEmail ใช้เหมือนกันทุก Step ใน text อาจใส่ Mailได้หลายmail เช่น Solos.T@samartcorp.com,Supinya.M@samartcorp.com,......
                tNuid: $('#tNuid').val(),        // Endorsement tNuid
                tNname: $('#tNname').val()      // Endorsement tNname
            },
            function(result){
                $('#checkdata').html(result);
                $('#btnUpAttach').click();
                loadProcess();
                menuCount();
                pageActive('rfcMyActivity.php');
            }
        );
    }else if(step==9){    //Add Step QC
        $.post("mainRFC/rfcAction.php",{
                pModule: e,
                pThis: f,
                nStep: step,
                Ptype_review: $('#type_review').val(),
                Ptestreview_no: $('#testreview_no').val(),
                Preview_defect: $('#review_defect').val(),
                Preview_item: $('#review_item').val(),
                Ptestdefect_no: $('#testdefect_no').val(),
                Ptypetest_defect: $('#typetest_defect').val(),
                Ptest_defect: $('#test_defect').val(),
                Ptest_item: $('#test_item').val(),
                ptNotePG: $('#notePG').val(),
                peffHourQC: $('#effHourQC').val(),      // ยังไม่ได้คำนวณ EFFORT
                peffMinuteQC: $('#effMinuteQC').val(),  // ยังไม่ได้คำนวณ EFFORT
                tReuid: $('#ReAllStep').val(),
                //tReuid: $('#AppPG').val(),
                gticketNo: $('#gticketNo').val(),
                grfcNo: $('#grfcNo').val(),
                tnEmail: $('#tnEmail').val(),    // Endorsement tnEmail ใช้เหมือนกันทุก Step ใน text อาจใส่ Mailได้หลายmail เช่น Solos.T@samartcorp.com,Supinya.M@samartcorp.com,......
                tNuid: $('#tNuid').val(),        // Endorsement tNuid
                tNname: $('#tNname').val()      // Endorsement tNname
            },
            function(result){
                $('#checkdata').html(result);
                $('#btnUpAttach').click();
                loadProcess();
                menuCount();
                pageActive('rfcMyActivity.php');
            }
        );
    }else if(step==10){    //Add Step QA
        $.post("mainRFC/rfcAction.php",{
                pModule: e,
                pThis: f,
                nStep: step,
                peffHourQA: $('#effHourQA').val(),      // ยังไม่ได้คำนวณ EFFORT
                peffMinuteQA: $('#effMinuteQA').val(),  // ยังไม่ได้คำนวณ EFFORT
                Ptype_review: $('#type_review').val(),
                Ptestreview_no: $('#testreview_no').val(),
                Preview_defect: $('#review_defect').val(),
                Preview_item: $('#review_item').val(),
                Ptestdefect_no: $('#testdefect_no').val(),
                Ptypetest_defect: $('#typetest_defect').val(),
                Ptest_defect: $('#test_defect').val(),
                Ptest_item: $('#test_item').val(),
                ptNotePG: $('#notePG').val(),
                tReuid: $('#ReAllStep').val(),
                //tReuid: $('#AppQC').val(),
                gticketNo: $('#gticketNo').val(),
                grfcNo: $('#grfcNo').val(),
                tnEmail1: $('#tnEmail1').val(),
                tnEmail2: $('#tnEmail2').val(),
                tNuid1: $('#tNuid1').val(),
                tNuid2: $('#tNuid2').val(),
                tnEmail: $('#tnEmail').val(),    // Endorsement tnEmail ใช้เหมือนกันทุก Step ใน text อาจใส่ Mailได้หลายmail เช่น Solos.T@samartcorp.com,Supinya.M@samartcorp.com,......
                tNuid: $('#tNuid').val(),        // Endorsement tNuid
                tNname: $('#tNname').val()      // Endorsement tNname
            },
            function(result){
                $('#checkdata').html(result);
                $('#btnUpAttach').click();
                loadProcess();
                menuCount();
                pageActive('rfcMyActivity.php');
            }
        );
    }else if(step==11){    //Add Step CD
        $.post("mainRFC/rfcAction.php",{
                pModule: e,
                pThis: f,
                nStep: step,
                ptcdStatus: $('#tcdStatus').val(),
                ptcdNote: $('#tcdNote').val(),
                ptcdDefact: $('#tcdDefact').val(),
                tReuid: $('#ReAllStep').val(),
                //tReuid: $('#AppPM').val(),
                gticketNo: $('#gticketNo').val(),
                grfcNo: $('#grfcNo').val(),
                tnEmail: $('#tnEmail').val(),
                tNuid: $('#tNuid').val(),
                tNname: $('#tNname').val()
            },
            function(result){
                $('#checkdata').html(result);
                $('#btnUpAttach').click();
                loadProcess();
                menuCount();
                pageActive('rfcMyActivity.php');
            }
        );
    }else if(step==12){    //Add Step CD2
        $.post("mainRFC/rfcAction.php",{
                pModule: e,
                pThis: f,
                nStep: step,
                tReuid: $('#ReAllStep').val(),
                //tReuid: $('#AppPM').val(),
                gticketNo: $('#gticketNo').val(),
                grfcNo: $('#grfcNo').val(),
                tnEmail2: $('#tnEmail2').val(),
                tNuid2: $('#tNuid2').val(),
                tNname2: $('#tNname2').val(),
                tnEmail: $('#tnEmail').val(),
                tNuid: $('#tNuid').val(),        // Endorsement tNuid
                tNname: $('#tNname').val()      // Endorsement tNname
            },
            function(result){
                $('#checkdata').html(result);
                loadProcess();
                menuCount();
                pageActive('rfcMyActivity.php');
            }
        );
    }else if(step==13){    //Add Step CC
        $.post("mainRFC/rfcAction.php",{
                pModule: e,
                pThis: f,
                nStep: step,
                ptccChgStatus: $('#tccChgStatus').val(),
                ptccReason: $('#tccReason').val(),
                ptccTotalDur: $('#tccTotalDur').val(),
                ptccEffort: $('#tccEffort').val(),
                ptccNote: $('#tccNote').val(),
                ptccProConfig: $('#tccProConfig').val(),
                tReuid: $('#ReAllStep').val(),
                //tReuid: $('#AppPM').val(),
                gticketNo: $('#gticketNo').val(),
                grfcNo: $('#grfcNo').val(),
                tnEmail: $('#tnEmail').val(),    // Endorsement tnEmail ใช้เหมือนกันทุก Step ใน text อาจใส่ Mailได้หลายmail เช่น Solos.T@samartcorp.com,Supinya.M@samartcorp.com,......
                tNuid: $('#tNuid').val(),        // Endorsement tNuid
                tNname: $('#tNname').val()       // Endorsement tNname
            },
            function(result){
                $('#checkdata').html(result);
                $('#btnUpAttach').click();
                loadProcess();
                menuCount();
                pageActive('rfcMyActivity.php');
            }
        );
    }else if(step==14){    //Add Step CC2
            $.post("mainRFC/rfcAction.php",{
                pModule: e,
                pThis: f,
                nStep: step,
                tReuid: $('#ReAllStep').val(),
                //tReuid: $('#AppPM').val(),
                gticketNo: $('#gticketNo').val(),
                grfcNo: $('#grfcNo').val(),
                tnEmail: $('#tnEmail').val(),    // Endorsement tnEmail ใช้เหมือนกันทุก Step ใน text อาจใส่ Mailได้หลายmail เช่น Solos.T@samartcorp.com,Supinya.M@samartcorp.com,......
                tNuid: $('#tNuid').val(),        // Endorsement tNuid
                tNname: $('#tNname').val()      // Endorsement tNname
            },
            function(result){
                $('#checkdata').html(result);
                loadProcess();
                menuCount();
                pageActive('rfcMyActivity.php');
            }
        );
    }else if(step==15){    //Add Step CC3
        $.post("mainRFC/rfcAction.php",{
                pModule: e,
                pThis: f,
                nStep: step,
                tReuid: $('#ReAllStep').val(),
                //tReuid: $('#AppPM').val(),
                gticketNo: $('#gticketNo').val(),
                grfcNo: $('#grfcNo').val(),
                tNuid2: $('#tNuid2').val(),
                tnEmail2: $('#tnEmail2').val(),
                tnEmail: $('#tnEmail').val(),    // Endorsement tnEmail ใช้เหมือนกันทุก Step ใน text อาจใส่ Mailได้หลายmail เช่น Solos.T@samartcorp.com,Supinya.M@samartcorp.com,......
                tNuid: $('#tNuid').val(),        // Endorsement tNuid
                tNname: $('#tNname').val()      // Endorsement tNname
            },
            function(result){
                $('#checkdata').html(result);
                loadProcess();
                menuCount();
                pageActive('rfcMyActivity.php');
            }
        );
    }
        // go to my RFC All status


    }

}

    function rejectRFC(e,f,step){
        $.post("mainRFC/rfcAction.php",{
                pModule: e,
                pThis: f,
                nStep: step
            },
            function(result){
                menuCount();
                pageActive('rfcMyActivity.php');
            }
        );
    }
    //   Start page PM Estimate
    function showEstFunc(a){
        if(a==1? $('#posFunc').css('display','none') : $('#posFunc').css('display','block')  );
    }
    function chkNum(ele)
    {
        var num = parseFloat(ele.value);
        //ele.value = num.toFixed(2);
    }
    //   end page PM Estimate

    function listDepart(q){

        $.post("mainRFC/listDepartment.php",{
            sCompany: q
        }
        ,function(result){
            $('#posDepartment').html(result);
        }
        );
    }
    function searchsendUser(){
        $.post("mainRFC/userNextStep.php",{
                sName: $('#sUsername').val(),
                sCompany: $('#sCompany').val(),
                sDepartment: $('#sDepartment').val()
            }
            ,function(result){
                $('#pAdd').html(result);
            }
        );
    }

    //Step Submit Post
    function sendToUser(){
        $.post("mainRFC/userNextStep.php",{
            sName: $('#tNname').val(),
            sDepartment: '',
            sCompany: '<?=$_SESSION['cCompCode'];?>'
        }
            ,function(result){
                $('#pAdd').html(result);
            }
        );
    }

    function toNextStep(a,b,c){
        $('#tNuid').val(a);
        $('#tNname').val(b);
        $('#tnEmail').val(c);
        $('button#BoxClose').trigger('click');
    }
    //Step Submit Post


    //QC testcase
    function checkListTC(a,b,c){

        $.post("mainRFC/checklistAction.php",{
            pModule: a,                     // Add / Edit /Del
            pPosChk: b,                        // checklist/checklistwork
            pThis: c,                        // id process del
            pListID: $('#addlistID').val(),
            pList: $('#addlist').val(),
            pListW: $('#addWwork').val(),
            pWListID: $('#addWListID').val(),
            pWList: $('#addWList').val()
        },
        function(result){
            $('#posCHKLIST').html(result);
            $('#addlistID').val('');
            $('#addlist').val('');
            $('#addWwork').val('');
            $('#addWListID').val('');
            $('#addWList').val('');
        }
        );
    }
    function checkListTR(a,b,c){
        $.post("mainRFC/checklistActionTR.php",{
            pModule: a,                     // Add / Edit /Del
            pPosChk: b,                        // checklist/checklistwork
            pThis: c,                        // id process del
            pListID: $('#addlistID').val(),
            pList: $('#addlist').val(),
            pListW: $('#addWwork').val(),
            pWListID: $('#addWListID').val(),
            pWList: $('#addWList').val()
            },
            function(result){
                $('#addlistID').val('');
                $('#addlist').val('');
                $('#addWwork').val('');
                $('#addWListID').val('');
                $('#addWList').val('');
                $('#TRposCHKLIST').html(result);
            }
        );
    }
    function qcSaveTest(a,b){
        $.post("mainRFC/qcSaveTest.php",{
            pModule: a,
            pThis: b,
            pQCrunid: $('#tQCrunID').val(),
            pQCcode: $('#tQCcode').val(),
            pQCpcode: $('#tQCpcode').val()
        },
            function(result){
                pageActive('newRFC.php?step=QC&id='+b);
            }
        );
    }
    function qcSaveTR(a,b){
        var count = $('#tCount').val();

        $.post("mainRFC/qcSaveTR.php",{
            pModule:a,
            pThis: b,
            pQCcount: $('#tCount').val(),
            pQCrunid: $('#tQCrunID').val(),
            pQCcode: $('#tQCcode').val(),
            pQCpcode: $('#tQCpcode').val()
        },
        function (result){
            pageActive('newRFC.php?step=QC&id='+b);
        });
    }
    function chgQCList(a,b,c){
        var PR = '';
        var PD = '';
        if(a=='L'){ // Test case list
            PR =  $('input[name=rdoListQ'+c+']:checked').val();
            PD =  $('#definedQ'+c).val();
        }
        if(a=='W'){ // Test case Work product
            PR =  $('input[name=ChkWQ'+c+']:checked').val();
            PD =  $('#definedWQ'+c).val();
        }
        if(a=='R'){  // Test Result
            PR =  $('input[name=rdoListQ'+c+']:checked').val();
            PD =  $('#definedQ'+c).val();
        }
        if(a=='P'){  // Test Result Work Product
            PR =  $('input[name=ChkWQ'+c+']:checked').val();
            PD =  $('#definedWQ'+c).val();
        }
        //alert(a+'+'+PR+'+'+b+c);
            $.post("mainRFC/changeList.php",{
                pModule: a,    //L / W  / R /P
                pCK: b,
                pResult: PR ,
                pDefact: PD
            },
            function(result){
                //pageActive('newRFC.php?step=QC&id='+b);
            }
            );
    }

    function chkRang(){

        var st = $("#targetStart").datepicker({ dateFormat: "yy-mm-dd" }).val();
        var fin = $('#targetFin').datepicker({ dateFormat: "yy-mm-dd" }).val();

        if(st > fin  && st!='' && fin!=''){
            alert("กำหนดวันที่เริ่มต้นกับวันที่เสร็จไม่ถูกต้อง"+st +"**"+fin);
        }

    }

    function goTimesheetSA(){
        var d1= $('#tFieldTicket').val();  //Ticket No tsheetDetail  tFieldTicket tFieldRFC
        var d2= $('#tFieldRFC').val();  //เลข RFC
        var d3= $('#tsheetDetail').val(); //change Request detail
        var d4= $('#tnPcode').val(); //change Request detail
        var d5= $('#tnUserRequest').val(); //change Request detail
        var d6= $('#tnApplication').val(); //change Request detail
        $('#fromRFC').val('SA||'+d1+'||'+d2+'||'+d3+'||'+d4+'||'+d5+'||'+d6);
        $('#frm2Timesheet').submit();
    }
    function goTimesheetPG(){
        var d1= $('#tFieldTicket').val();  //Ticket No tsheetDetail  tFieldTicket tFieldRFC
        var d2= $('#tFieldRFC').val();  //เลข RFC
        var d3= $('#tsheetDetail').val(); //change Request detail
        var d4= $('#tnPcode').val(); //change Request detail
        var d5= $('#tnUserRequest').val(); //change Request detail
        var d6= $('#tnApplication').val(); //change Request detail
        $('#fromRFC').val('PG||'+d1+'||'+d2+'||'+d3+'||'+d4+'||'+d5+'||'+d6);
        $('#frm2Timesheet').submit();
    }
    function goTimesheetQC(){
        var d1= $('#tFieldTicket').val();  //Ticket No tsheetDetail  tFieldTicket tFieldRFC
        var d2= $('#tFieldRFC').val();  //เลข RFC
        var d3= $('#tsheetDetail').val(); //change Request detail
        var d4= $('#tnPcode').val(); //change Request detail
        var d5= $('#tnUserRequest').val(); //change Request detail
        var d6= $('#tnApplication').val(); //change Request detail
        $('#fromRFC').val('QC||'+d1+'||'+d2+'||'+d3+'||'+d4+'||'+d5+'||'+d6);
        $('#frm2Timesheet').submit();
    }
    function goTimesheetQA(){
        var d1= $('#tFieldTicket').val();  //Ticket No tsheetDetail  tFieldTicket tFieldRFC
        var d2= $('#tFieldRFC').val();  //เลข RFC
        var d3= $('#tsheetDetail').val(); //change Request detail
        var d4= $('#tnPcode').val(); //change Request detail
        var d5= $('#tnUserRequest').val(); //change Request detail
        var d6= $('#tnApplication').val(); //change Request detail
        $('#fromRFC').val('QA||'+d1+'||'+d2+'||'+d3+'||'+d4+'||'+d5+'||'+d6);
        $('#frm2Timesheet').submit();
    }

<? }
?>