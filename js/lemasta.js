function showTooltip(x, y, contents) {
        $('<div id="tooltip">' + contents + '</div>').css( {
            position: 'absolute',
            display: 'none',
            top: y + 5,
            left: x + 5,
            border: '1px solid #fdd',
            padding: '2px',
            'background-color': '#fee',
            opacity: 0.80
        }).appendTo("body").fadeIn(200);
    }

    function show(arr,ind) {
	var previousPoint = null;

	var plot=$.plot($("#placeholder"), 
		[arr[ind]], 
		{lines: {show: true },
		 points: {show: true },
		 grid: { hoverable: true, clickable: true},
		 xaxis: { mode: null, tickSize: 1, tickDecimals: 0} }
		);
	 var previousPoint = null;
	 $("#placeholder").bind("plothover", function (event, pos, item) {
            if (item) {
                if (previousPoint != item.datapoint) {
                    previousPoint = item.datapoint;
                    
                    $("#tooltip").remove();
		    var    y = item.datapoint[1];
		    y=parseFloat(y).toFixed(2);
		    // alert(item.datapoint[1]);
                    showTooltip(item.pageX, item.pageY, y);
                }
            }
            else {
                $("#tooltip").remove();
                previousPoint = null;            
            }
    });


    }
    function myfill(text) {
	var arr=text.split("\n");
	var parr=preparr(arr);
	//alert(parr);
	$("#output").find("input").each(function(i) {
		    $(this).click(
		    function(){
		//	alert("I am here");
		//	alert(parr[0]);
			show(parr,i);
		    	})
		    });
    }

      function preparr(arr) {
	var time=[2007,2008,2009,2010,2011,2012];
	var res=[];
	for (var i=1; i<arr.length-1; i++) {
	    var row=arr[i].split("\t");
	    var temp=[];
	    for(var j=1;j<row.length; j++) {
		var dt=new Date(time[j],0,1);
		//	temp.push([dt.getTime(),row[j]]);
		temp.push([time[j],row[j]]);
	    }
	    
	    // alert(row);
	    res.push(temp);
	   }
	return res;
    }

