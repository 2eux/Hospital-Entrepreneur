<h1>Server Status</h1>
<p>This is the Server Status Window. For the average Mind everything here won't make sense. So don't try to understand it ;)</p>


			<pre style="font-size: 12px"><?php
			    # status.php -- very simple server status monitor
			    # Get and display load average times 3
			    $load = sys_getloadavg();
			    echo "LoadAverage1:\t $load[0]\n";
			    echo "LoadAverage5:\t $load[1]\n";
			    echo "LoadAverage15:\t $load[2]\n";
			    # Get and display all sorts of memory usage info
			    echo join( '', file( '/proc/meminfo' ) );
			    # Get and display disk usage percentages
			    $df = `/bin/df`;
			    foreach( explode( "\n", $df ) as $line )
			    {
				if( preg_match( "/(\d+%)\s+(\S+)$/", $line, $matches ) )
				{
				    $fs = $matches[ 2 ];
				    $usage = $matches[ 1 ];
				    echo "Usage_$fs: $usage\n";
				}
			    }
			    # Count running processes
			    $procs = `/bin/ps -e|wc -l`;
			    echo "RunningProcesses: $procs\n";
			?>


-------------------------------------------------------------------------------------------------------------
<?php $proc = `ps aux`;
$proc = str_replace("<s","s", $proc);
echo "List of running Processes: \n" . $proc; ?>
-------------------------------------------------------------------------------------------------------------
<?php $proc = `crontab -u root -l`;
echo "Crontab: \n". $proc; ?>

			</pre>

