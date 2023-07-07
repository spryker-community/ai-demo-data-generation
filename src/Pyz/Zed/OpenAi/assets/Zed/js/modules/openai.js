$(document).ready(function () {

    attachModal();
    attachOpenAiCompletionApiToToForm('textarea[name*="description"]', function(event, languageContext) {
        // provide product name to prompt
        let nameInput = $('input[name*="'+languageContext+'][name"]');
        return {title: nameInput.val()};
    });

    attachOpenAiCompletionApiToToForm('input[name*="meta_title"]', function(event, languageContext) {
        let nameInput = $('input[name*="'+languageContext+'][name"]');
        return {title: nameInput.val() };
    });

    attachOpenAiCompletionApiToToForm('input[name*="meta_keywords"]', function(event, languageContext) {
        let nameInput = $('input[name*="'+languageContext+'][name"]');
        return {title: nameInput.val() };
    });

    attachOpenAiCompletionApiToToForm('input[name*="meta_description"]', function(event, languageContext) {
        let nameInput = $('input[name*="'+languageContext+'][name"]');
        return {title: nameInput.val() };
    });

    function attachModal()
    {
        var modal = $(`
                <div id="myModal" class="modal">
                  <div class="modal-dialog">
                    <div class="modal-content">

                      <!-- Modal Header -->
                      <div class="modal-header">
                        <h4 class="modal-title">OpenAI <img src='https://seeklogo.com/images/O/open-ai-logo-8B9BFEDC26-seeklogo.com.png' style='width: 15px; padding-left: 5px;' /></h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                      </div>

                        <div id="spinner" style="display: block;">
                              <i class="fa fa-spinner fa-spin"></i>  <span id="spinner-text">Collecting prompts...</span>
                        </div>

                      <!-- Modal body -->
                      <div class="modal-body" id="modal-body" style="display: none;">
                        <div>Assign Prompt:</div> <select id="openapi-choices" class="form-control"></select>
                      </div>

                      <!-- Modal footer -->
                      <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="saveBtn">Save</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                      </div>

                    </div>
                  </div>
                </div>`);

        $("#page-wrapper").after(modal);

    };

    function attachOpenAiCompletionApiToToForm(targetInputNameSelector, collectPromptContextCallback)
    {
        const currentDomain = window.location.protocol + "//" + window.location.host;
        const descriptionElements = document.querySelectorAll(targetInputNameSelector);

        for (var i = 0; i < descriptionElements.length; i++) {
            var descriptionElement = descriptionElements[i];
            var uniqueId=descriptionElement.id;

            var languageContext = descriptionElement.name.match(/_(\w{2}_\w{2})/)[1];
            var newButton = $("<button disabled class='btn btn-xs btn-outline openai-generate' style='border-top-right-radius: 0.25rem;border-bottom-right-radius: 0.25rem;' data-openai-target='"+uniqueId+"' data-openai-language='" + languageContext + "' data-openai-event='"+uniqueId+"_event''>Generate</button>" +
                "<button class='btn btn-xs rounded-right openai-edit' style='border-bottom-left-radius: 0.25rem;border-top-left-radius: 0.25rem;' data-openai-event='"+uniqueId+"_event''><i class='fas fa-edit'></i></button>");

            $(descriptionElement).parent().after(newButton);
        }

        if (descriptionElements.length === 0)
        {
            return 0;
        }
        const spinner = document.getElementById('spinner');
        const spinnerText = document.getElementById('spinner-text');
        const modalBody = document.getElementById('modal-body');
        const selectBox = document.querySelector('#openapi-choices');
        const modalJQuery = $('#myModal');

        unlockUiGenerateButtons();

        function unlockUiGenerateButtons() {
            document.querySelector(".openai-generate").setAttribute("disabled", true);

            fetch(currentDomain + '/open-ai/ajax/get-open-ai-prompt-to-event-collection')
                .then(response => response.json())
                .then(data => {
                    for (var i = 0; i < data.length; i++) {
                        const element = document.querySelector(".openai-generate[data-openai-event='"+data[i].event+"']");
                        if (element) {
                            element.removeAttribute("disabled");
                        }
                    }
                })
                .catch(error => {
                    console.error(error)
                });
        }

        $(".openai-generate").unbind("click");
        $(".openai-generate").on("click", function(event) {
            event.preventDefault();

            let eventName = $(this).data("openai-event");
            let languageContext = $(this).data("openai-language");
            let target = $(this).data("openai-target");
            let context = collectPromptContextCallback(event, languageContext);


            modalJQuery.modal("show");
            loading("Executing Prompt...");
            executePrompt(eventName, context, function(data) {
                selectBox.innerHTML = data.choices.map(completionChoice => '<option title="'+escapeHtml(completionChoice.text)+'" value="'+escapeHtml(completionChoice.text)+'">'+completionChoice.text.substring(0,70)+'</option>').join('');
                loaded();
                modalJQuery.find(".modal-footer button").unbind("click");
                modalJQuery.find(".modal-footer button").on("click", function(event) {
                    document.getElementById(target).value = selectBox.value;
                    modalJQuery.modal("hide");
                }.bind(this));
            });
        });

        function escapeHtml(unsafe)
        {
            return unsafe
                .replace(/&/g, "&amp;")
                .replace(/^\n{2}/, "")
                .replace(/</g, "&lt;")
                .replace(/>/g, "&gt;")
                .replace(/"/g, "&quot;")
                .replace(/'/g, "&#039;");
        }

        function executePrompt(eventName, context, successCallback) {
            const endpoint = currentDomain + '/open-ai/ajax/execute-prompt';

            const data = {
                event: eventName,
                context: context
            };

            const options = {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(data)
            };

            fetch(endpoint, options)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    successCallback(data);
                    console.log(data);
                })
                .catch(error => {
                    console.error('There was a problem with the fetch operation:', error);
                });
        }

        function updateModalChoicesWithPromptCollection() {
            fetch(currentDomain + '/open-ai/ajax/get-open-ai-prompt-collection')
                .then(response => response.json())
                .then(data => {
                    loaded();
                    selectBox.innerHTML = data.map(prompt => `<option value="${prompt.id_openai_prompt}">${prompt.name}</option>`).join('');
                })
                .catch(error => {
                    loaded();
                    console.error(error)
                });

        }

        function assignPromptToEvent(prompt, event) {
            const endpoint = currentDomain + '/open-ai/ajax/assign-event-to-prompt';
            const data = {
                prompt: prompt,
                event: event
            };

            const options = {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(data)
            };

            fetch(endpoint, options)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    modalJQuery.modal("hide");
                    unlockUiGenerateButtons();
                    console.log(data);
                })
                .catch(error => {
                    console.error('There was a problem with the fetch operation:', error);
                });
        }

        $(".openai-edit").unbind("click");
        $(".openai-edit").on("click", function(event) {
            event.preventDefault();
            loading("Collecting Prompts...");
            updateModalChoicesWithPromptCollection();

            modalJQuery.modal("show");
            modalJQuery.find(".modal-footer button").unbind("click");
            modalJQuery.find(".modal-footer button").on("click", function(event) {
                loading("Assigning Prompt...");
                assignPromptToEvent(selectBox.value, $(this).data("openai-event"));
            }.bind(this));
        });

        function loading(text) {
            spinner.style.display = 'block';
            spinnerText.innerText = text;
            modalBody.style.display = 'none';
        }

        function loaded() {
            spinner.style.display = 'none';
            spinnerText.value = '';
            modalBody.style.display = 'block';
        }
    }
});
