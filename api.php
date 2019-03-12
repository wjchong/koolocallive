<?php

<<<<<<< HEAD
require_once "./config.php";
$posted = file_get_contents("php://input");

if ($posted != "")
    file_put_contents("./post.txt", $posted);
else
    exit("[]");

=======

require_once "./config.php";

// define ("MYSQL_CONN", $conn);

$posted = file_get_contents("php://input");

// exit($posted);
>>>>>>> 30a5a237de95c0a6bbca6492b80b042d1b0de032

$localOrders = json_decode($posted);

// Retrieve the non-zero status
$zeros = array();
$completes = array();
<<<<<<< HEAD
$locals = array();

foreach ($localOrders as $order)
{
    /*
=======

foreach ($localOrders as $order)
{
>>>>>>> 30a5a237de95c0a6bbca6492b80b042d1b0de032
    if ($order->status == "0")
    {
        $zeros[] = $order;
    }
<<<<<<< HEAD
    if ($order->status == "2") {
        $completes[] = $order;
    }
    */
    $locals[] = $order;
}

function UpdateOrder($orderid, $orderstatus)
{
    global  $conn;
    //$conn = mysqli_connect("localhost", "root", "", "koofamil_demo");
=======

    if ($order->status == "2") {
        $completes[] = $order;
    }
}

if ($posted != "") file_put_contents("./post.txt", $posted);

function UpdateOrder($orderid, $orderstatus)
{
    global $conn;
	
>>>>>>> 30a5a237de95c0a6bbca6492b80b042d1b0de032
    $sql = "UPDATE order_list SET status = $orderstatus WHERE id = $orderid";

    //echo $sql . "\n";

    $query = mysqli_query($conn, $sql);
<<<<<<< HEAD
    //mysqli_close($conn);
}

// Retrieve all order lists
$query = mysqli_query($conn, "SELECT order_list.*, users.mobile_number FROM order_list inner join users on order_list.user_id = users.id ORDER BY `created_on` DESC");

$orders = array();
$now = date_create(date("Y-m-d G:i:s"));

while($r = mysqli_fetch_assoc($query))
{
    $record = date_create($r['created_on']);
    $delay = date_diff($now, $record, true);

    if ($delay->d <= 14)
    {
        $orders[] = $r;
    }

}

$remotes = array();

foreach ($orders as $order)
{
    $found = false;
    $record = null;
    foreach ($locals as $local)
    {

        if ($local->merchant_id == $order["merchant_id"] &&
            $local->user_id == $order["user_id"] &&
            $local->product_id == $order["product_id"] &&
            $local->invoice_no == $order["invoice_no"]
        )
        {
            $found = true;
            $record = $local;
            break;
        }
    }

    if ($found)
    {
        //echo $order["status"] . " - " . $record->status;
        switch (strval($order["status"]))
        {
            case "0":
                switch (strval($record->status))
                {
                    case "1":
                    case "2":
                        // Update online
                        UpdateOrder($order["id"], $record->status);
                        break;
                    default:
                        break;
                }
                break;
            case "1":
                // Do nothing
                break;
            case "2":
                if (strval($record->status) == "1")
                {
                    // Update online
                    UpdateOrder($order["id"], $record->status);
                }
                break;
        }
    }
    else {
        $remotes[] = $order;
    }
}

//print_r($remotes);
// exit("Quit");

// Retrieve all order lists
$query = mysqli_query($conn, "SELECT users.* FROM users");

$users = array();

while($r = mysqli_fetch_assoc($query))
{
    $users[] = $r;
}

/*

//mysqli_close($conn);
=======
    // mysqli_close($conn);
}


function RetrieveDemo()
{
	// $conn = MYSQL_CONN; // mysqli_connect("localhost", "koofamil_demo", "6bepaAQCM9r-", "koofamil_demo");

    global $conn;

    if (!$conn)
	{
		echo "database error"; die;
	}

	// Retrieve all order lists
	$query = mysqli_query($conn, "SELECT order_list.*, users.mobile_number FROM order_list inner join users on order_list.user_id = users.id ORDER BY `created_on` DESC");

	$orders = array();
	$now = date_create(date("Y-m-d G:i:s"));

	while($r = mysqli_fetch_assoc($query))
	{
		$record = date_create($r['created_on']);
		$delay = date_diff($now, $record, true);

		if ($delay->d <= 14)
		{
			$orders[] = $r;
		}

	}
	// mysqli_close($conn);
	
	return $orders;
}

$orders = RetrieveDemo();
$returns = array();
foreach ($orders as $order)
{
    switch (strval($order['status']))
    {
        case "0":
            $found = false;
            foreach ($localOrders as $local)
            {
                if ($local->created_on == $order["created_on"])
                {
                    // Update here
                    if (strval($local->status) != "0")
                    {
                        // Update order
                        UpdateOrder($order["id"], $local->status);
                        //echo "Updated\n";
                    }
                    $found = true;
                }
            }

            if (!$found)
            {
                // Insert here
                $returns[] = $order;
            }
            break;
        case "1":
            $found = false;
            foreach ($localOrders as $local)
            {
                if ($local->created_on == $order["created_on"])
                {
                    // Update here
                    if (intval($local->status) == "1")
                    {
                        $found = true;
                    }
                }
            }

            if (!$found)
            {
                // Insert here
                $returns[] = $order;
            }
            break;
        case "2":
            $found = false;
            foreach ($localOrders as $local)
            {
                if ($local->created_on == $order["created_on"])
                {
                    if (strval($local->status) == "0")
                    {
                        // Update local
                    }
                    else {
                        // Update Remote
                        UpdateOrder($order["id"], $local->status);
                        //echo "Updated\n";
                        $found = true;
                    }
                }
            }

            if (!$found)
            {
                // Insert here
                $returns[] = $order;
            }
            break;

    }
}
header("Content-type: application/json");
echo json_encode($returns);
exit();
>>>>>>> 30a5a237de95c0a6bbca6492b80b042d1b0de032

// Create order with pending status
$pendingOrders = array();
foreach ($orders as $order)
{
    if ($order['status'] == "0")
    {
        $pendingOrders[] = $order;
    }
}

// Retrieve the only updated rder
$updated = array();
foreach ($completes as $local)
{
    $found = false;

    foreach ($pendingOrders as $pending)
    {
        if ($local->created_on == $pending['created_on'] &&
            $local->user_id == $pending['user_id'] &&
            $local->product_id == $pending['product_id'] &&
            $local->merchant_id == $pending['merchant_id']
        )
        {

<<<<<<< HEAD
            //UpdateOrder($pending['id'], $local->status);
=======
            UpdateOrder($pending['id'], $local->status);
>>>>>>> 30a5a237de95c0a6bbca6492b80b042d1b0de032
            $updated[] = $pending;
        }
    }
}

<<<<<<< HEAD
//print_r($updated);
//exit();
=======

//print_r($updated);
//exit("Done");

// Refresh Orders
unset($orders);
$orders = RetrieveDemo();


// Create order with pending status
unset($pendingOrders);
$pendingOrders = array();
foreach ($orders as $order)
{
    if ($order['status'] == "0")
    {
        $pendingOrders[] = $order;
    }
}
>>>>>>> 30a5a237de95c0a6bbca6492b80b042d1b0de032


// Retrieve new order
$returns = array();
foreach($pendingOrders as $order)
{
    $found = false;
    foreach ($zeros as $zero)
    {
        if ($zero->created_on == $order['created_on'] && $order['status'] == "0")
        {
            //echo $zero->status . " found\n";
            $found = true;
            break;

        }
    }

    if (!$found) $returns[] = $order;
}
<<<<<<< HEAD
*/
header("Content-type: application/json");

$inserted = array("orders" => $remotes, "users" => $users);
echo json_encode($inserted);
=======

//echo "Local Zeros: " . sizeof($zeros) . "\n";
//echo "Remote Zero: " . sizeof($pendingOrders) . "\n";
//echo "Different: " . sizeof($returns) . "\n";

header("Content-type: application/json");
echo json_encode($returns);
>>>>>>> 30a5a237de95c0a6bbca6492b80b042d1b0de032

?>