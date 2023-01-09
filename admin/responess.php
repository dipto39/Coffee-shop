<?php
require('./db/pdo.php');
$obj = new database();
session_start();
$getData = json_decode(file_get_contents("php://input"), true);

// login check

if (isset($_POST['login'])) {
    $email = htmlentities($_POST['email']);
    $password = md5($_POST['password']);
    $obj->select("users", null, null, "email = '$email' and password ='$password'", null, null);
    $res = $obj->show_result();
    if (count($res[0]) > 0) {
        $_SESSION['email'] = $email;
        echo json_encode(["status" => true], true);
    } else {
        echo json_encode(["status" => false], true);
    }
}

// get summary

if(isset($_POST['get_summary'])){
            $data="";
            $obj->select("booking", null, null, null, null, null);
            $res = $obj->show_result();
            $to = "<span>" . count($res[0]) . "</span>";
            
            $obj->select("tables", null, null, "status = 0", null, null);
            $res = $obj->show_result();
            $ft = "<span>" . count($res[0]) . "</span>";
            
            $date= date("Y-m-d");
            $obj->select("booking", null, null, "adate like '%$date%'", null, null);
            $res = $obj->show_result();
            $ot = "<span>" . count($res[0]) . "</span>";
            

            $obj->select("contact", null, null, "status = 0", null, null);
            $res = $obj->show_result();
            $uq = "<span>" . count($res[0]) . "</span>";
            
            $data .= '<div id="summery_data" class=""><div class="summary_body"><div class="dflex"><div class="single">';
            $data .=   $to;
            $data .= '<h3>Tootal Order</h3></div><div class="single">';
            $data .=  $ft;

            $data .= '<h3>Free Table</h3></div></div><div class="dflex"><div class="single">';
            $data .=  $ot;

            $data .= '<h3>Order Today</h3></div><div class="single">';
            $data .=  $uq;

            $data .= '<h3>Unread queary</h3></div></div> </div></div>';
            echo $data;
}
if(isset($_POST['get_orders'])){
            $obj->select("booking", null, null, null, "date desc",null);
            $res = $obj->show_result();
            $data = '';
            
            $data .= '<div id="orders" ><h3>All orders</h3><div class="order_body"><table><tr><th>Si</th><th>Name</th><th>Contact</th><th>Table No</th><th>Time</th><th>Sataus</th><th>Action</th></tr>';
    
            $i = 1;
            foreach ($res[0] as $key) {
                $data .= ' <tr><td>' . $i . '</td><td>' . $key['name'] . '</td><td>' . $key['contact'] . '</td><td>' . $key['tb_no'] . '</td><td>' . $key['time'] ." | ". $key['date']. '</td><td>';
                 if($key['status'] == 0){$data.= "pending";}
                 elseif($key['status'] == 1){$data.= "confirm";} 
                 else{
                    $data.="cacelled";
                 }
                
                $data.='</td><td><button class="take_action" data-attr="' . $key['id'] . '">Take action</button></td></tr>';
                $i++;
            }

        
            $data .= '</table>
                </div>
            </div>';
            echo $data;
}
if(isset($_POST['get_Unread_query'])){
 
            $obj->select("contact", null, null, "status = 1", "date desc", null);
            $res = $obj->show_result();
            
            $data='<div id="querys"><div class="query_body">
                    <div class="query_head"><div class="unread">Unread queries</div><div class="read active_read">Read queries</div></div> <div class="querys"><div class="unread_querys"><table><tr><th>Si</th><th>Name</th><th>Contact</th><th>message</th><th>IP</th><th>Action</th></tr>';
                             
                             $j=1;
                             if(count($res[0]) > 0){
                            foreach($res[0] as $val){
                                $data.= '<tr><td>'.$j.'</td><td>'.$val['name'].'</td><td>'.$val['email'].'</td><td>'.$val['message'].'</td><td>'.$val['ip'].'</td><td class="d-flex"><button class="read_modal" data-attr="'.$val['id'].'">Read</button><button data-attr="'.$val['id'].'" class="delete_query">Delete</button></td></tr>';
                                $j++;
                            }
                        }else{
                            $data.="<tr><td colspan='6'>No record found...!</td></tr>";
                        }
                    
                                
                            $data.='</table>
                        </div>
                    </div>
                </div>
            </div>';
            echo $data;
}
if(isset($_POST['get_read_query'])){
    $data='<div id="querys"><div class="query_body">
    <div class="query_head"><div class="unread active_read">Unread queries</div><div class="read ">Read queries</div></div> <div class="querys"><div class="read_querys">
            <table>
                <tr>
                    <th>Si</th>
                    <th>Name</th>
                    <th>Contact</th>
                    <th>message</th>
                    <th>IP</th>
                    <th>Action</th>
                </tr>';
               
                 
                 $obj->select("contact", null, null, "status = 0 ", null, null);
                 $res = $obj->show_result();
                 
             $k=1;
             if(count($res[0]) > 0){
            foreach($res[0] as $val){
            $data.= '<tr><td>'.$k.'</td> <td>'.$val['name'].'</td><td>'.$val['email'].'</td><td>'.$val['message'].'</td><td>'.$val['ip'].'</td><td><button class="read_modal" data-attr="'.$val['id'].'">Read</button></td></tr>';
                $k++;
            }
        }else{
            $data.="<tr><td colspan='6'>No record found...!</td></tr>";

        }
    
            $data.='</table>
        </div></div>
</div>
</div>';
echo $data;
}
if(isset($_POST['confirm_order'])){
    $id =$_POST['confirm_order'];
    
    if($obj->update("booking",['status' => 1],"id = $id")){
        $res = $obj->show_result();
        echo json_encode(['status'=> true]);
    }else{
        echo json_encode(['status'=> false]);

    }
    
}
if(isset($_POST['cancel_order'])){
    $id =$_POST['cancel_order'];
    
    if($obj->update("booking",['status' => 2],"id = $id")){
        $res = $obj->show_result();
        echo json_encode(['status'=> true]);
    }else{
        echo json_encode(['status'=> false]);

    }
    
}
// get read model 
if(isset($_POST['read_modal'])){
    $id =$_POST['read_modal'];
    $obj->select("contact", null, null, "id =1 ", null, null);
    $res = $obj->show_result();
    $data= "";
    if(count($res[0]) > 0){
        $data .= '<div class="modal_body">
        <span class="mclose">✖</span>
        <h2>Query Details</h2>
    <form action="">
    <label for="name">
        Name:
        <input type="text" value="'.$res[0][0]['name'].'" disabled>
    </label>
    <label for="name">
        Email:
        <input type="text" value="'.$res[0][0]['email'].'" disabled>
    </label>
    <label for="name">
        Message:
        <textarea name="" id="" cols="30" rows="3" disabled>'.$res[0][0]['message'].'</textarea>
    </label>
    
    </form>
        <div class="action_status">
            <button data-attr="'.$res[0][0]['id'].'" class="read_it">OK</button>
        </div>
    </div>';
    echo json_encode(["status" => true,"message" => $data]);
    }else{
        echo json_encode(["status"=> false]);
    }


}
// read ok
if(isset($_POST['read_ok'])){
    $id =$_POST['read_ok'];
    
    if($obj->update("contact",['status' => 1],"id = $id")){
        $res = $obj->show_result();
        echo json_encode(['status'=> true]);
    }else{
        echo json_encode(['status'=> false]);

    }
}
// read ok
if(isset($_POST['delete_query'])){
    $id =$_POST['delete_query'];
    
    if($obj->delete("contact","id = $id")){
        $res = $obj->show_result();
        echo json_encode(['status'=> true]);
    }else{
        echo json_encode(['status'=> false]);

    }
}

