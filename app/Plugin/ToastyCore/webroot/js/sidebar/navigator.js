$(document).ready(function() {
    
    var contentNavigatorState = new NavigatorState({identifier: "content-navigator"});
    var state = contentNavigatorState.get();
    
    $("#content-navigator a[href=" + state + "]").tab('show');
    
    $("#content_tab_tab").click(function() {
        contentNavigatorState.set("#content_tab")
    });
    $("#elements_tab_tab").click(function() {
        contentNavigatorState.set("#elements_tab")
    });
    $("#files_tab_tab").click(function() {
        contentNavigatorState.set("#files_tab")
    });
    
});
