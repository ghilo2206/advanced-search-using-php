<?php
    $conn = mysqli_connect("localhost", "root", "", "searchengineadv"); 
    $with_any_one_of = "";
    $with_the_exact_of = "";
    $without = "";
    $starts_with = "";
    $search_in = "";
    $advance_search_submit = "";
    
    $queryCondition = "";
    if(!empty($_POST["search"])) {
        // $advance_search_submit = $_POST["advance_search_submit"];
        foreach($_POST["search"] as $k=>$v){
            if(!empty($v)) {

                $queryCases = array("with_any_one_of","with_the_exact_of","without","starts_with");
                if(in_array($k,$queryCases)) {
                    if(!empty($queryCondition)) {
                        $queryCondition .= " AND ";
                    } else {
                        $queryCondition .= " WHERE ";
                    }
                }
                switch($k) {
                    case "with_any_one_of":
                        $with_any_one_of = $v;
                        $wordsAry = explode(" ", $v);
                        $wordsCount = count($wordsAry);
                        for($i=0;$i<$wordsCount;$i++) {
                            if(!empty($_POST["search"]["search_in"])) {
                                $queryCondition .= $_POST["search"]["search_in"] . " LIKE '%" . $wordsAry[$i] . "%'";
                            } else {
                                $queryCondition .= "title LIKE '" . $wordsAry[$i] . "%' OR description LIKE '" . $wordsAry[$i] . "%'";
                            }
                            if($i!=$wordsCount-1) {
                                $queryCondition .= " OR ";
                            }
                        }
                        break;
                    case "with_the_exact_of":
                        $with_the_exact_of = $v;
                        if(!empty($_POST["search"]["search_in"])) {
                            $queryCondition .= $_POST["search"]["search_in"] . " LIKE '%" . $v . "%'";
                        } else {
                            $queryCondition .= "title LIKE '%" . $v . "%' OR description LIKE '%" . $v . "%'";
                        }
                        break;
                    case "without":
                        $without = $v;
                        if(!empty($_POST["search"]["search_in"])) {
                            $queryCondition .= $_POST["search"]["search_in"] . " NOT LIKE '%" . $v . "%'";
                        } else {
                            $queryCondition .= "title NOT LIKE '%" . $v . "%' AND description NOT LIKE '%" . $v . "%'";
                        }
                        break;
                    case "starts_with":
                        $starts_with = $v;
                        if(!empty($_POST["search"]["search_in"])) {
                            $queryCondition .= $_POST["search"]["search_in"] . " LIKE '" . $v . "%'";
                        } else {
                            $queryCondition .= "title LIKE '" . $v . "%' OR description LIKE '" . $v . "%'";
                        }
                        break;
                    case "search_in":
                        $search_in = $_POST["search"]["search_in"];
                        break;
                }
            }
        }
    }
    $orderby = " ORDER BY id desc"; 
    $sql = "SELECT * FROM links " . $queryCondition;
    $result = mysqli_query($conn,$sql);
    
?>

<!doctype html>
                        <html>
                            <head>
                                <meta charset='utf-8'>
                                <meta name='viewport' content='width=device-width, initial-scale=1'>
                                <title>Advanced Search PHP</title>
                                <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/css/bootstrap.min.css' rel='stylesheet'>
                                <link href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css' rel='stylesheet'>
                                <script type='text/javascript' src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>
                                <style>::-webkit-scrollbar {
                                  width: 8px;
                                }
                                /* Track */
                                ::-webkit-scrollbar-track {
                                  background: #f1f1f1; 
                                }
                                 
                                /* Handle */
                                ::-webkit-scrollbar-thumb {
                                  background: #888; 
                                }
                                
                                /* Handle on hover */
                                ::-webkit-scrollbar-thumb:hover {
                                  background: #555; 
                                } body{

    background-color: #00838F;
}


.advanced{

    text-decoration: none;
    font-size: 15px;
    font-weight: 500;
}


.btn-secondary,
.btn-secondary:focus,
.btn-secondary:active


 {
    color: #fff;
    background-color: #00838f !important;
    border-color: #00838f !important;
    box-shadow: none;
}


.advanced{

    color: #00838f !important;
}

.form-control:focus{
    box-shadow: none;
    border: 1px solid #00838f;


}
 .box{
    padding: 20px;
    
 }

</style>
                                </head>
                                <body className='snippet-body'>
                                <div class="container mt-5">

        <div class="row d-flex justify-content-center">
<form name="frmSearch" method="post" action="index.php">
            <div class="col-md-10">

                <div class="card p-3  py-4">

                    <h5>An Easier way to find your Blog posts</h5>

                    <div class="row g-3 mt-2">


                        <div class="col-md-6">

                            <input type="text" value="<?php echo $with_any_one_of; ?>" name="search[with_any_one_of]" class="form-control" placeholder="With Any One of the Words:">
                            
                        </div>

                        <div class="col-md-3">

                            <input type="submit" name="go" class="btn btn-secondary btn-block" value="Search Results">
                            
                        </div>
                        
                    </div>


                    <div class="mt-3">
                        
  <a data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample" class="advanced">
    Advance Search With Filters <i class="fa fa-angle-down"></i>
  </a>
 

<div class="collapse" id="collapseExample">
  <div class="card card-body">
      
     <div class="row">

        <div class="col-md-4">

            <input type="text" name="search[with_the_exact_of]" value="<?php echo $with_the_exact_of; ?>" placeholder="With the Exact String:" class="form-control">
            
        </div>


        <div class="col-md-4">

            <input type="text" class="form-control" placeholder="Without:" name="search[without]"  value="<?php echo $without; ?>">
            
        </div>
         

         <div class="col-md-4">

            <input  name="search[starts_with]" value="<?php echo $starts_with; ?>" type="text" class="form-control" placeholder="Starts With:">
            
        </div>
        <div class="row  g-3 mt-2">
        <div class="col-md-3">
                                <div class="form-control ">
                        <select name="search[search_in]" id="search_in" class="demoInputBox">
                            <option class="form-control" value="">Select Column</option>
                            <option class="form-control"  value="title" <?php if($search_in=="title") { echo "selected"; } ?>>Title</option>
                            <option class="form-control" value="description" <?php if($search_in=="description") { echo "selected"; } ?>>Description</option>
                        </select>
                    </div>
 

</div>

        </div>
         
     </div>

  </div>
</div>


                    </div>


                    


            
                </div>
                
            </div>
            </form>
            <div class="container">
                <div class="row">
                    
                    <?php while($row = mysqli_fetch_assoc($result)) { ?>
            <div class="col-md-5">
                <div class="box">
                <div ><strong><?php echo $row["title"]; ?></strong></div>
                <div class=" result-description"><?php echo $row["description"]; ?></div>
                </div>
            </div>
            <?php } ?>
                    
                </div>
            </div>


                        <?php while($row = mysqli_fetch_assoc($result)) { ?>
            <div>
                <div><strong><?php echo $row["title"]; ?></strong></div>
                <div class="result-description"><?php echo $row["description"]; ?></div>
            </div>
            <?php } ?>
            
        </div>

        
        


    </div>
                                <script type='text/javascript' src='https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/js/bootstrap.bundle.min.js'></script>
                                <script type='text/javascript' src='#'></script>
                                <script type='text/javascript' src='#'></script>
                                <!-- <script type='text/javascript'>#</script> -->
                                <script type='text/javascript'>var myLink = document.querySelector('a[href="#"]');
                                myLink.addEventListener('click', function(e) {
                                  e.preventDefault();
                                });</script>
                            
                                </body>
                            </html>
