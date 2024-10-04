class ModalMixin {
    constructor(modalId, title, bodyContent, actionType, httpAction, closeForm) {
        this.modalId = modalId || 'dynamicModal';
        this.title = title;
        this.bodyContent = bodyContent;
        this.actionType = actionType;  // 'edit', 'create', 'delete'
        this.httpAction = httpAction
        this.closeForm = closeForm
        this.modal = new bootstrap.Modal(document.getElementById(this.modalId), {});

        // Create modal container
        this.createModal();
    }

    createModal() {
        const modalHtml = `
            <div class="modal fade" id="${this.modalId}" tabindex="-1" aria-labelledby="${this.modalId}Label" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="${this.modalId}Label">${this.title}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="${this.hide}()"></button>
                  </div>
                  <div class="modal-body">
                    ${this.bodyContent}
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="${this.hide}()">Close</button>
                    <button type="button" class="btn btn-primary" id="modalActionBtn">${this.getActionText()}</button>
                  </div>
                </div>
              </div>
            </div>
        `;

        const modalContainer = document.getElementById('modal-container');

        if (modalContainer) {
            modalContainer.insertAdjacentHTML('beforeend', modalHtml);
        } else {
            console.error('Element with id "modal-container" not found.');
        }

        // Add event listener to trigger HTTP action
        document.getElementById('modalActionBtn').addEventListener('click', () => {
            console.log('triggered HTTP action')
            this.httpAction()
            const modal = bootstrap.Modal.getInstance(document.getElementById(this.modalId));
            modal.hide();
        });
    }

    getActionText() {
        switch (this.actionType) {
            case 'edit':
                return 'Save changes';
            case 'create':
                return 'Create';
            case 'delete':
                return 'Delete';
            default:
                return 'Submit';
        }
    }

    show() {
        this.modal.show()
    }

    hide() {
        this.modal.hide()
    }

    destroy() {
        const modalElement = document.getElementById(this.modalId);
        if (modalElement) {
            modalElement.parentNode.removeChild(modalElement);  // Remove modal from the DOM
        }
    }
}

export default ModalMixin