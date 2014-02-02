 <div class="modal-header">
    <h3>Select a Document Type</h3>
</div>
<div class="modal-body">
  <div class="tgrid">
    <div class="grid-item{{selected.item == document_type ? ' active': ''}}" ng-repeat="document_type in items" ng-click="selected.item = document_type">
          <span class="item-icon glyphicon glyphicon-file"></span>
          <div class="caption">
            <a>{{document_type.DocumentType.name}}</a>
          </div>
      </div>
    </div>
    <div class="clearfix"></div>
</div>
<div class="modal-footer">
    <button class="btn btn-primary" ng-click="ok()">OK</button>
    <button class="btn btn-warning" ng-click="cancel()">Cancel</button> 
</div>
