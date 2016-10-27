/**
 * Created by cocoa on 9/27/16.
 */

$("#checkAll").click(function () {
    var cAll = document.getElementById("checkAll");
    var fm = document.getElementById("form");
    var eles = fm.getElementsByTagName("input")
    for(var i=0;i<eles.length;i++){
        eles[i].checked = cAll.checked;
    }
});

