<?php

function genDefaultGetParam(){
    $keyword = isset($_GET['keyword'])?$_GET['keyword']:'';
    $option_val = isset($_GET['option'])?$_GET['option']:'';
    $help = isset($_GET['__filter'])?'&__filter='.$_GET['__filter']:'';
    return '?option='.$option_val.'&keyword='.$keyword.$help;
}


if($total>0){

?>
    <div align="center">
    <ul class="pagination">
    <li>
        <a href="<?php echo genDefaultGetParam();?>&start=<?php echo $page_con - 2; ?>&page=<?php echo $page_con - 1; ?>" <?php echo $page_con == 1 ? "onclick='return false;'" : ""; ?> >Previous</a>
    </li>
    <?php
    $page = ceil($total / $limit);
    for ($i = 1;
         $i <= $page;
         $i++) {
        if ($page_con == $i) {
            ?>
            <li>
                <a href="<?php echo genDefaultGetParam();?>&start=<?php echo($i - 1); ?>&page=<?php echo $i; ?>"><?php echo "<b>" . $i . "</b>"; ?></a>
            </li>
        <?php
        } else {
            ?>
                <li>
                    <a href="<?php echo genDefaultGetParam();?>&start=<?php echo($i - 1); ?>&page=<?php echo $i; ?>"><?php echo $i; ?></a>
                </li>


            <?php
            }
        }
        ?>
        <li>
            <a href="<?php echo genDefaultGetParam();?>&start=<?php echo $page_con; ?>&page=<?php echo $page_con + 1; ?>" <?php echo $page_con == ($i - 1) ? "onclick='return false;'" : ""; ?> >Next</a>
        </li>
    </ul>
</div>

<?php }?>