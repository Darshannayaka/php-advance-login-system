<!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@mdo">Open modal for @mdo</button> -->


<div class="modal fade" id="categoryModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Add Your Thought To Discussion</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="/forum/partials/_handleCategory.php" method="post">
                    <div class="mb-3">
                        <label for="recipient-name" class="col-form-label">Category Title:</label>
                        <input type="text" class="form-control" id="categoryTitle" name="categoryTitle">
                    </div>
                    <div class="mb-3">
                        <label for="message-text" class="col-form-label">category description:</label>
                        <textarea class="form-control" id="categoryDes" name="categoryDes"></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Send message</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>