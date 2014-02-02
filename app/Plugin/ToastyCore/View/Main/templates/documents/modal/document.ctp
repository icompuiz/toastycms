 <div class="modal-header">
  <h3>Select a Document</h3>
  <div class="btn-group">
    <button class="btn btn-default"><span class="glyphicon glyphicon-chevron-up" ng-click="changeDocument(document.parent.Document.id)"></span></button>
    <button class="btn btn-default" ng-repeat="pitem in document.Document.path.stack">{{pitem}} <span class="glyphicon glyphicon-chevron-right"></span></button>
  </div>
</div>
<div class="modal-body">
<div ng-if="document.children.length == 0">
  <p class="text-muted">No documents</p>
</div>
  <div class="tgrid">
    <div ng-if="currentDocument.Document.id != childDocument.Document.id" class="grid-item{{selected.item == childDocument ? ' active': ''}}" ng-repeat="childDocument in document.children" ng-click="selected.item = childDocument" ng-dblclick="changeDocument(childDocument.Document.id)">
      <span class="item-icon glyphicon glyphicon-file"></span>
      <div class="caption">
        <a>{{childDocument.Document.name}}</a>
      </div>
    </div>
    <div class="tgrid-backdrop" ng-click="selectNone()"></div>
    <div class="clearfix"></div>
  </div>
</div>
<div class="modal-footer">
  <button class="btn btn-primary" ng-click="ok()">OK</button>
  <button class="btn btn-warning" ng-click="cancel()">Cancel</button> 
</div>
