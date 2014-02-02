 <div class="modal-header">
    <h3>Select a Document Type</h3>
</div>
<div class="modal-body">
  <div class="tgrid">
      <div class="grid-item " ng-repeat="document in documents">
        <a href="#/documents/edit/{{document.Document.id}}">
            <span class="item-icon glyphicon glyphicon-file"></span>
            <div class="caption">
              {{document.Document.name}}
          </div>
        </a>
        </div>
      </div>
</div>
<div class="modal-footer">
    <button class="btn btn-primary" ng-click="ok()">OK</button>
    <button class="btn btn-warning" ng-click="cancel()">Cancel</button> 
</div>
