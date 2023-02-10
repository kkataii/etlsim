<div class="text-center">
	<ul class="pagination pagination-lg pagination-md pagination-sm">
	<?php
		function pagination($totalRow, $perpage ,$page, $url){   

		    $adjacents = "2"; 
	    	$page = ($page == 1 ? 1 : $page);  		
	    	$prev = $page - 1;							
	    	$next = $page + 1;

	    	$lastpage = ceil($totalRow/$perpage);
	    	$lpm1 = $lastpage - 1;

	    	$pagination = "";
	    	if($lastpage > 1)
	    	{	
	    		$pagination .= "<ul class='pagination'>";
	            $pagination .= "<li class='details'>&nbsp;ໜ້າ $page ຂອງ $lastpage</li>";
	                if ($page == 1) {
	                    	$pagination.= "<li><a class='current'>Prev</a></li>";
	                    }else{
	                    $pagination.= "<li><a href='{$url}pagei=$prev&start=".$perpage*($prev-1)."' class='BtnPage' id='$prev'>Prev</a></li>";
	                }
	    		if ($lastpage < 7 + ($adjacents * 2))
	    		{	
	    			for ($counter = 1; $counter <= $lastpage; $counter++)
	    			{
	    				if ($counter == $page)
	    					$pagination.= "<li><a class='current'>$counter</a></li>";
	    				else
	    					$pagination.= "<li><a href='{$url}pagei=$counter&start=".$perpage*($counter-1)."' class='BtnPage' id='$counter'>$counter</a></li>";					
	    			}
	    		}
	    		elseif($lastpage > 5 + ($adjacents * 2))
	    		{
	    			if($page < 1 + ($adjacents * 2))		
	    			{
	    				for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
	    				{
	    					if ($counter == $page)
	    						$pagination.= "<li><a class='current'>$counter</a></li>";
	    					else
	    						$pagination.= "<li><a href='{$url}pagei=$counter&start=".$perpage*($counter-1)."' class='BtnPage' id='$counter'>$counter</a></li>";					
	    				}
	    				$pagination.= "<li class='dot'>...</li>";
	    				$pagination.= "<li><a href='{$url}pagei=$lpm1&start=".$perpage*($lpm1-1)."' class='BtnPage' id='$lpm1'>$lpm1</a></li>";
	    				$pagination.= "<li><a href='{$url}pagei=$lastpage&start=".$perpage*($lastpage-1)."' class='BtnPage' id='$lastpage'>$lastpage</a></li>";		
	    			}
	    			elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
	    			{
	    				$pagination.= "<li><a href='{$url}pagei=1&start=".($perpage*0)."' class='BtnPage' id='1'>1</a></li>";
	    				$pagination.= "<li><a href='{$url}pagei=2&start=".($perpage*1)."' class='BtnPage' id='2'>2</a></li>";
	    				$pagination.= "<li class='dot'>...</li>";
	    				for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
	    				{
	    					if ($counter == $page)
	    						$pagination.= "<li><a class='current'>$counter</a></li>";
	    					else
	    						$pagination.= "<li><a href='{$url}pagei=$counter&start=".$perpage*($counter-1)."' class='BtnPage' id='$counter'>$counter</a></li>";					
	    				}
	    				$pagination.= "<li class='dot'>..</li>";
	    				$pagination.= "<li><a href='{$url}pagei=$lpm1&start=".$perpage*($lpm1-1)."' class='BtnPage' id='$lpm1'>$lpm1</a></li>";
	    				$pagination.= "<li><a href='{$url}pagei=$lastpage&start=".$perpage*($lastpage-1)."' class='BtnPage' id='$lastpage'>$lastpage</a></li>";		
	    			}
	    			else
	    			{
	    				$pagination.= "<li><a href='{$url}pagei=1&start=".($perpage*0)."' class='BtnPage' id='1'>1</a></li>";
	    				$pagination.= "<li><a href='{$url}pagei=2&start=".($perpage*1)."' class='BtnPage' id='2'>2</a></li>";
	    				$pagination.= "<li class='dot'>..</li>";
	    				for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
	    				{
	    					if ($counter == $page)
	    						$pagination.= "<li><a class='current'>$counter</a></li>";
	    					else
	    						$pagination.= "<li><a href='{$url}pagei=$counter&start=".$perpage*($counter-1)."' class='BtnPage' id='$counter'>$counter</a></li>";					
	    				}
	    			}
	    		}
	    		if ($page < $counter - 1){ 
	    			$pagination.= "<li><a href='{$url}pagei=$next&start=".$perpage*($next-1)."' class='BtnPage' id='$next'> Next</a></li>";
	                $pagination.= "<li><a href='{$url}pagei=".$lastpage."&start=".$perpage*($lastpage-1)."' class='BtnPage' id='$lastpage'>Last</a></li>";
	    		}else{
	    			$pagination.= "<li><a class='current'> Next</a></li>";
	                $pagination.= "<li><a class='current'>Last </a></li>";
	            }
	    		$pagination.= "</ul>\n";	
	    	}
	        return $pagination;
	    } 
		?>
	</ul>
</div>