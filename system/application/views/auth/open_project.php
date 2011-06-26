<div>
<?php
if($this->uri->segment(3)=='all')
{
	echo "tampil semua data open project";
}

else if($this->uri->segment(3) > 0)
{
	echo "tampilkan project tertentu secara detail";
}

else
{
	echo "salah id";
}
?>
</div>