const fetchAmenities = async () => {
    const origin = window.location.origin;
    const response = await fetch(`${origin}/admin/amenities`);
    if(response.status === 200){
        const data = await response.json();
        console.log(data);
        return data;
    }
    return null;
}
const storeAmenities = async (data) => {
    const origin = window.location.origin;
    const response = await fetch(`${origin}/admin/amenities`, {
        method: 'POST',
        body: data
    });
    if(response.status === 200){
        const data = await response.json();
        console.log(data);
        return data.amenity;
    }
    return [];
}
let amenitiesData = [];
const init = async ()=> {
    amenitiesData = await fetchAmenities();
    console.log(amenitiesData);
}
init().then(r => console.log(r));



var amenitesData = {}
var selectedId

function handleOpenCustomAmenties(id) {
    let modalarea = document.querySelector(`.modal_area_${id}`).parentElement
    let a = modalarea.querySelector('.custom-amenities-card-area')
    let b = modalarea.querySelector('.create-custom-amenities-btn')
    if (a.classList.contains('hidden')) {
        a.classList.remove('hidden')
        b.textContent = 'Cancel Custom Amenities'
    }
    else {
        a.classList.add('hidden')
        b.textContent = 'Create Custom Amenities'
    }
}

function handleClickAddPrice(element) {
    const card = element.closest('.amenities-card');
    card.querySelector('.amenties-enter-price-btn').classList.remove('hidden');
    card.querySelector('.amenities-heading').classList.add('red');
    card.querySelector('.amenties-edit-button').classList.add('hidden');
}
function handleClickEndterPrice(element) {
    const card = element.closest('.amenities-card');
    card.querySelector('.amenties-enter-price-btn').classList.add('hidden');
    card.querySelector('.amenites-price-input-box').classList.remove('hidden');
    card.querySelector('.amenties-price-submit-button').classList.remove('hidden');
    const input = card.querySelector('.amenites-price-input');
    if (input) {
        input.focus();
    }
}
function handleClickSubmitPrice(element, id) {
    const card = element.closest('.amenities-card');
    let value = card.querySelector('.amenites-price-input').value
    let name = card.querySelector('.amenities-heading').innerText
    let stringId = String(Number(id));
    if (amenitesData[stringId] === undefined) {
        amenitesData[stringId] = [];
    }
    if (value !== '') {
        card.classList.add('red')
        card.querySelector('.amenites-price-input-box').classList.add('hidden');
        card.querySelector('.amenties-price-submit-button').classList.add('hidden');
        card.querySelector('.amenites-price-show-box').classList.remove('hidden');
        card.querySelector('.amenties-price-delete-button').classList.remove('hidden');
        card.querySelector('.amenites-price-show-box').innerHTML = `<span>$ ${value}</span>`;
        const amenity = amenitiesData.find(item => item.id === Number(card.id));
        amenitesData[stringId].push({ id: amenity.id, name: amenity.name, image: amenity.image, price: value });
    }
    else {
        card.querySelector('.amenites-price-input-box').classList.add('red');
    }
    console.log(amenitesData, stringId)
}
function handleClickRemovePrice(element, id) {
    let stringId = String(Number(id));
    const card = element.closest('.amenities-card');
    card.querySelector('.amenites-price-show-box').classList.add('hidden');
    card.querySelector('.amenties-price-delete-button').classList.add('hidden');
    card.classList.remove('red')
    card.querySelector('.amenties-edit-button').classList.remove('hidden');
    card.querySelector('.amenities-heading').classList.remove('red');
    card.querySelector('.amenites-price-input-box').classList.remove('red');
    card.querySelector('.amenites-price-input').value = ''
    if (amenitesData[stringId]) {
        amenitesData[stringId] = amenitesData[stringId].filter(item => item.id !== card.id);
    }
    console.log(amenitesData)
}

function handleCreateCustomAmenties(id) {
    /*let modalarea = document.querySelector(`.modal_area_${id}`)
    let value = modalarea.querySelector('.custom-amenities-name-input');
    let area = modalarea.querySelector('.amenities-card-area');
    if (value.value === '') {
        value.classList.add('red')
    }
    else {
        value.classList.remove('red');
        const origin = window.location.origin;
        let card = `
                                                <div class="amenities-card flex gap-6" id=${Date.now()}>
                                                    <div class="flex gap-3" style="align-items: center;">
                                                        <div>
                                                            <img src="${origin}/uploads/amenities/${value.image}" alt="" width="40" height="40" />
                                                        </div>
                                                        <div>
                                                            <p class="amenities-heading red">${value.value}</p>
                                                            <button class="amenties-enter-price-btn" type="button" onclick="handleClickEndterPrice(this)">Enter
                                                                Price</button>
                                                            <div class="amenites-price-input-box flex gap-5 hidden">
                                                                <span>$</span>
                                                                <input type="number" class="amenites-price-input" placeholder="0.0">
                                                            </div>
                                                            <div class="amenites-price-show-box flex gap-5 hidden">

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="flex h-full">
                                                        <button type="button" class="amenties-edit-button hidden" onclick="handleClickAddPrice(this)">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                                                <g clip-path="url(#clip0_59_31)">
                                                                    <path d="M17.7778 0C18.3671 0 18.9324 0.234126 19.3491 0.650874C19.7659 1.06762 20 1.63285 20 2.22222V17.7778C20 18.3671 19.7659 18.9324 19.3491 19.3491C18.9324 19.7659 18.3671 20 17.7778 20H2.22222C1.63285 20 1.06762 19.7659 0.650874 19.3491C0.234126 18.9324 0 18.3671 0 17.7778V2.22222C0 1.63285 0.234126 1.06762 0.650874 0.650874C1.06762 0.234126 1.63285 0 2.22222 0H17.7778ZM15.2222 7.05556C15.4667 6.82222 15.4667 6.43333 15.2222 6.2L13.8 4.77778C13.745 4.71961 13.6786 4.67327 13.6051 4.64161C13.5315 4.60994 13.4523 4.59361 13.3722 4.59361C13.2921 4.59361 13.2129 4.60994 13.1394 4.64161C13.0658 4.67327 12.9995 4.71961 12.9444 4.77778L11.8333 5.88889L14.1111 8.16667L15.2222 7.05556ZM4.44444 13.2667V15.5556H6.73333L13.4667 8.82222L11.1778 6.53333L4.44444 13.2667Z" fill="#2F2F2F"></path>
                                                                </g>
                                                                <defs>
                                                                    <clipPath id="clip0_59_31">
                                                                        <rect width="20" height="20" rx="10" fill="white"></rect>
                                                                    </clipPath>
                                                                </defs>
                                                            </svg>
                                                        </button>
                                                        <button type="button" class="amenties-price-submit-button hidden" onclick="handleClickSubmitPrice(this,${id})">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
                                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M9 18C10.1819 18 11.3522 17.7672 12.4442 17.3149C13.5361 16.8626 14.5282 16.1997 15.364 15.364C16.1997 14.5282 16.8626 13.5361 17.3149 12.4442C17.7672 11.3522 18 10.1819 18 9C18 7.8181 17.7672 6.64778 17.3149 5.55585C16.8626 4.46392 16.1997 3.47177 15.364 2.63604C14.5282 1.80031 13.5361 1.13738 12.4442 0.685084C11.3522 0.232792 10.1819 -1.76116e-08 9 0C6.61305 3.55683e-08 4.32387 0.948211 2.63604 2.63604C0.948212 4.32387 0 6.61305 0 9C0 11.3869 0.948212 13.6761 2.63604 15.364C4.32387 17.0518 6.61305 18 9 18ZM8.768 12.64L13.768 6.64L12.232 5.36L7.932 10.519L5.707 8.293L4.293 9.707L7.293 12.707L8.067 13.481L8.768 12.64Z" fill="#008232"></path>
                                                            </svg>
                                                        </button>
                                                        <button type="button" class="amenties-price-delete-button hidden" onclick="handleClickRemovePrice(this,${id})">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                                                <g clip-path="url(#clip0_24_1581)">
                                                                    <path d="M2.92984 17.07C1.97473 16.1475 1.21291 15.044 0.688821 13.824C0.164731 12.604 -0.111131 11.2918 -0.122669 9.96397C-0.134207 8.63618 0.11881 7.31938 0.621618 6.09042C1.12443 4.86145 1.86696 3.74493 2.80589 2.80601C3.74481 1.86708 4.86133 1.12455 6.09029 0.62174C7.31926 0.118932 8.63605 -0.134085 9.96385 -0.122547C11.2916 -0.111009 12.6038 0.164853 13.8239 0.688943C15.0439 1.21303 16.1474 1.97486 17.0698 2.92996C18.8914 4.81598 19.8994 7.342 19.8766 9.96397C19.8538 12.5859 18.8021 15.0941 16.948 16.9481C15.0939 18.8022 12.5858 19.8539 9.96385 19.8767C7.34188 19.8995 4.81586 18.8915 2.92984 17.07ZM11.3998 9.99996L14.2298 7.16996L12.8198 5.75996L9.99984 8.58996L7.16984 5.75996L5.75984 7.16996L8.58984 9.99996L5.75984 12.83L7.16984 14.24L9.99984 11.41L12.8298 14.24L14.2398 12.83L11.4098 9.99996H11.3998Z" fill="#BD191F"></path>
                                                                </g>
                                                                <defs>
                                                                    <clipPath id="clip0_24_1581">
                                                                        <rect width="20" height="20" fill="white"></rect>
                                                                    </clipPath>
                                                                </defs>
                                                            </svg>
                                                        </button>
                                                    </div>
                                                </div>
      `

        area.insertAdjacentHTML('beforeend', card)
        value.value = ''

    }*/
}

function handleCloseAmenties() {
    let a = document.querySelector('#modalAmenties').classList.add('hidden')
}

function createSelectedAmenties(id) {
    let stringId = String(Number(id));
    const dataBtn = document.querySelector(`.create-new-amenities-btn[data-id="${id}"]`);
    const parentWrapper = dataBtn.closest('.package-amenities-wrapper');
    const amenityInput = parentWrapper.querySelector('.package-amenities-input');
    let amenitiesValue = [];

    if (amenityInput.value?.trim()) {
        try {
            amenitiesValue = JSON.parse(amenityInput.value);
        } catch (e) {
            console.error("Invalid JSON in amenityInput.value", e);
        }
    }
    const selectedAmenitiesArea = parentWrapper.querySelector('.selected-amenties-area');
    selectedAmenitiesArea.innerHTML = '';
    const origin = window.location.origin;
    amenitiesValue?.forEach(item => {

        let card = `
                                               <div class="amenities-card flex gap-6 red mb-1" id=${item.id} style="width:100%"  >
                                                    <div class="flex gap-3" style="align-items: center;">
                                                        <div>
                                                            <img src="${origin}/uploads/amenities/${item.image}" alt="" width="40" height="40" />
                                                        </div>
                                                        <div>
                                                            <p class="amenities-heading red">${item.name}</p>

                                                            <div class="amenites-price-show-box flex gap-5"><span>$ ${item.price}</span></div>
                                                        </div>
                                                    </div>
                                                    <div class="flex h-full">
                                                        <button type="button" class="amenties-price-delete-button" onclick="handleRemoveSelectedAmenties(this,${id})">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                                                <g clip-path="url(#clip0_24_1581)">
                                                                    <path d="M2.92984 17.07C1.97473 16.1475 1.21291 15.044 0.688821 13.824C0.164731 12.604 -0.111131 11.2918 -0.122669 9.96397C-0.134207 8.63618 0.11881 7.31938 0.621618 6.09042C1.12443 4.86145 1.86696 3.74493 2.80589 2.80601C3.74481 1.86708 4.86133 1.12455 6.09029 0.62174C7.31926 0.118932 8.63605 -0.134085 9.96385 -0.122547C11.2916 -0.111009 12.6038 0.164853 13.8239 0.688943C15.0439 1.21303 16.1474 1.97486 17.0698 2.92996C18.8914 4.81598 19.8994 7.342 19.8766 9.96397C19.8538 12.5859 18.8021 15.0941 16.948 16.9481C15.0939 18.8022 12.5858 19.8539 9.96385 19.8767C7.34188 19.8995 4.81586 18.8915 2.92984 17.07ZM11.3998 9.99996L14.2298 7.16996L12.8198 5.75996L9.99984 8.58996L7.16984 5.75996L5.75984 7.16996L8.58984 9.99996L5.75984 12.83L7.16984 14.24L9.99984 11.41L12.8298 14.24L14.2398 12.83L11.4098 9.99996H11.3998Z" fill="#BD191F"></path>
                                                                </g>
                                                                <defs>
                                                                    <clipPath id="clip0_24_1581">
                                                                        <rect width="20" height="20" fill="white"></rect>
                                                                    </clipPath>
                                                                </defs>
                                                            </svg>
                                                        </button>
                                                    </div>
                                                </div>
                                             `
        selectedAmenitiesArea.insertAdjacentHTML('beforeend', card)
    })
}

function handleOpenAmentiesModal(element) {
    selectedId = element.dataset.id;
    const modal = document.querySelector('#modalAmenties')
    const modal_Areas = modal.querySelectorAll('[class^="modal_area"]');
    modal_Areas.forEach(area => {
        area.classList.add('hidden');
    });

    let modalarea = document.querySelector(`.modal_area_${selectedId}`)
    document.querySelector('#modalAmenties').classList.remove('hidden')
    if (modalarea !== null) {

        document.querySelector(`.modal_area_${selectedId}`).classList.remove('hidden')
        // createAmentiesCard(selectedId)
    }
    else {
        createModalHtml(selectedId)
        createAmentiesCard(selectedId)
    }
    handleCustomAmenityCreate(selectedId);
}
window.handleOpenAmentiesModal = handleOpenAmentiesModal;

function handleRemoveSelectedAmenties(element, id) {
    let stringId = String(Number(id));
    const card = element.closest('.amenities-card');
    amenitesData[stringId] = amenitesData[stringId].filter(item => item.id !== Number(card.id));
    let b = document.querySelector(`.create-new-amenities-btn[data-id="${id}"]`)?.parentElement;
    let input = b.querySelector('.package-amenities-input');
    if (amenitesData[stringId]) {
        input.value = JSON.stringify(amenitesData[stringId]);
    } else {
        input.value = '';
    }
    // console.log(amenitesData[stringId],card.id,input.value)
    createSelectedAmenties(id)
    handleRemoveCardFromModal(card.id, id)
}

function createAmentiesCard(id) {
    let modalarea = document.querySelector(`.modal_area_${id}`)
    let a = modalarea.querySelector('.amenities-card-area')
    a.innerHTML = null
    const origin = window.location.origin;
    amenitiesData.forEach(item => {
        let card = `
                                  <div class="amenities-card flex gap-6" id=${item.id}>
                                                <div class="flex gap-3" style="align-items: center;" >
                                                    <div>
                                                        <img src="${origin}/uploads/amenities/${item.image}" alt='image' width="40" height="41"  />
                                                    </div>
                                                    <div>
                                                        <p class="amenities-heading">${item.name}</p>
                                                        <button class="amenties-enter-price-btn hidden"
                                                                type="button"
                                                                onclick="handleClickEndterPrice(this)">Enter
                                                            Price</button>
                                                        <div class="amenites-price-input-box flex gap-5 hidden">
                                                            <span>$</span>
                                                            <input type="number" class="amenites-price-input"
                                                                   placeholder="0.0" />
                                                        </div>
                                                        <div class="amenites-price-show-box flex gap-5 hidden">

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="flex h-full">
                                                    <button type="button" class="amenties-edit-button"
                                                            onclick="handleClickAddPrice(this)">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="20"
                                                             height="20" viewBox="0 0 20 20" fill="none">
                                                            <g clip-path="url(#clip0_59_31)">
                                                                <path
                                                                    d="M17.7778 0C18.3671 0 18.9324 0.234126 19.3491 0.650874C19.7659 1.06762 20 1.63285 20 2.22222V17.7778C20 18.3671 19.7659 18.9324 19.3491 19.3491C18.9324 19.7659 18.3671 20 17.7778 20H2.22222C1.63285 20 1.06762 19.7659 0.650874 19.3491C0.234126 18.9324 0 18.3671 0 17.7778V2.22222C0 1.63285 0.234126 1.06762 0.650874 0.650874C1.06762 0.234126 1.63285 0 2.22222 0H17.7778ZM15.2222 7.05556C15.4667 6.82222 15.4667 6.43333 15.2222 6.2L13.8 4.77778C13.745 4.71961 13.6786 4.67327 13.6051 4.64161C13.5315 4.60994 13.4523 4.59361 13.3722 4.59361C13.2921 4.59361 13.2129 4.60994 13.1394 4.64161C13.0658 4.67327 12.9995 4.71961 12.9444 4.77778L11.8333 5.88889L14.1111 8.16667L15.2222 7.05556ZM4.44444 13.2667V15.5556H6.73333L13.4667 8.82222L11.1778 6.53333L4.44444 13.2667Z"
                                                                    fill="#2F2F2F" />
                                                            </g>
                                                            <defs>
                                                                <clipPath id="clip0_59_31">
                                                                    <rect width="20" height="20" rx="10"
                                                                          fill="white" />
                                                                </clipPath>
                                                            </defs>
                                                        </svg>
                                                    </button>
                                                    <button type="button"
                                                            class="amenties-price-submit-button hidden"
                                                            onclick="handleClickSubmitPrice(this,${id})">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="18"
                                                             height="18" viewBox="0 0 18 18" fill="none">
                                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                                  d="M9 18C10.1819 18 11.3522 17.7672 12.4442 17.3149C13.5361 16.8626 14.5282 16.1997 15.364 15.364C16.1997 14.5282 16.8626 13.5361 17.3149 12.4442C17.7672 11.3522 18 10.1819 18 9C18 7.8181 17.7672 6.64778 17.3149 5.55585C16.8626 4.46392 16.1997 3.47177 15.364 2.63604C14.5282 1.80031 13.5361 1.13738 12.4442 0.685084C11.3522 0.232792 10.1819 -1.76116e-08 9 0C6.61305 3.55683e-08 4.32387 0.948211 2.63604 2.63604C0.948212 4.32387 0 6.61305 0 9C0 11.3869 0.948212 13.6761 2.63604 15.364C4.32387 17.0518 6.61305 18 9 18ZM8.768 12.64L13.768 6.64L12.232 5.36L7.932 10.519L5.707 8.293L4.293 9.707L7.293 12.707L8.067 13.481L8.768 12.64Z"
                                                                  fill="#008232" />
                                                        </svg>
                                                    </button>
                                                    <button type="button"
                                                            class="amenties-price-delete-button hidden"
                                                            onclick="handleClickRemovePrice(this,${id})">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="20"
                                                             height="20" viewBox="0 0 20 20" fill="none">
                                                            <g clip-path="url(#clip0_24_1581)">
                                                                <path
                                                                    d="M2.92984 17.07C1.97473 16.1475 1.21291 15.044 0.688821 13.824C0.164731 12.604 -0.111131 11.2918 -0.122669 9.96397C-0.134207 8.63618 0.11881 7.31938 0.621618 6.09042C1.12443 4.86145 1.86696 3.74493 2.80589 2.80601C3.74481 1.86708 4.86133 1.12455 6.09029 0.62174C7.31926 0.118932 8.63605 -0.134085 9.96385 -0.122547C11.2916 -0.111009 12.6038 0.164853 13.8239 0.688943C15.0439 1.21303 16.1474 1.97486 17.0698 2.92996C18.8914 4.81598 19.8994 7.342 19.8766 9.96397C19.8538 12.5859 18.8021 15.0941 16.948 16.9481C15.0939 18.8022 12.5858 19.8539 9.96385 19.8767C7.34188 19.8995 4.81586 18.8915 2.92984 17.07ZM11.3998 9.99996L14.2298 7.16996L12.8198 5.75996L9.99984 8.58996L7.16984 5.75996L5.75984 7.16996L8.58984 9.99996L5.75984 12.83L7.16984 14.24L9.99984 11.41L12.8298 14.24L14.2398 12.83L11.4098 9.99996H11.3998Z"
                                                                    fill="#BD191F" />
                                                            </g>
                                                            <defs>
                                                                <clipPath id="clip0_24_1581">
                                                                    <rect width="20" height="20" fill="white" />
                                                                </clipPath>
                                                                </defs>
                                                                </svg>
                                                                </button>
                                                                </div>
                                                                </div>
                                                                `

        a.insertAdjacentHTML('beforeend', card)
    })



}

function handleRemoveCardFromModal(id, areaID) {
    let modalarea = document.querySelector(`.modal_area_${areaID}`)
    const cardarea = modalarea.querySelector('.amenities-card-area')
    const card = cardarea.querySelector(`[id="${id}"]`);
    const button = card.querySelector('.amenties-price-delete-button')
    button.click()
}

function handleSaveAmenties(id) {
    document.querySelector('#modalAmenties').classList.add('hidden');
    let b = document.querySelector(`.create-new-amenities-btn[data-id="${id}"]`)?.parentElement;
    let input = b.querySelector('.package-amenities-input');
    let stringId = String(Number(id));
    if (amenitesData[stringId]) {
        input.value = JSON.stringify(amenitesData[stringId]);
    } else {
        input.value = '';
    }
    // Trigger the change event
    const event = new Event('change', { bubbles: true });
    input.dispatchEvent(event);
}

function createModalHtml() {
    const modal = document.querySelector('#modalAmenties')
    const origin = window.location.origin;
    const html = `
        <div class='modal_area_${selectedId} modal_area' >
            <div class="p-8 relative ">
                <button id="closeAmentiesBtn" type="button" class=" text-gray-500 hover:text-black text-xl absolute"
                    style="top: 0px;right: 8px;font-size: 47px;" onclick="cloaseAmentiesModalCrossBtn(${selectedId})">×</button>
                    <div class="amenties-modal-heading">Standard Amenities</div>
                    <div class="amenities-card-area mt-1" data-id=${selectedId}></div>
                    <div class="p-2 custom-amenities-card-area hidden">
                        <p class="custom-amenities-heading">Custom Amenities</p>
                        <div class="w-full">
                            <input class="custom-amenities-input" type="file" name="custom_amenities" id="custom-amenities" hidden="">
                            <div class="flex justify-start items-center gap-05">
                                <img class="display-icon" src="${origin}/admins/images/placeholder-icon.png" alt="" draggable="false">
                                <label class="icon-upload-btn custom-amenities-icon-upload-btn" for="custom-amenities">Upload Icon</label>
                            </div>
                            <p class="error-text border-box img-error"></p>
                        </div>
                        <input class="custom-amenities-name-input" type="text" placeholder="Free WiFi" />
                        <button type="button" onclick="handleCreateCustomAmenties(${selectedId})" class="custom-amenities-create-button">CREATE</button>
                        <p class="error-text border-box amenity-error" style="padding-top: 10px;"></p>
                    </div>
                </div>
            </div>
            <div class="flex w-full">
                <button class="create-custom-amenities-btn" type="button" onclick="handleOpenCustomAmenties(${selectedId})">Create Custom Amenities</button>
                <button class="custom-amenities-save-btn" onclick="handleSaveAmenties(${selectedId})" type="button">Save</button>
            </div>
        </div>
    `;
    modal.insertAdjacentHTML('beforeend', html);
}


function cloaseAmentiesModalCrossBtn(id) {
    document.querySelector('#modalAmenties').classList.add('hidden')
    document.querySelector(`.modal_area_${id}`).classList.add('hidden')
}

const handleAmenityInputChange = () => {
    // Use JavaScript event delegation
    document.addEventListener('change', function(e) {
        // Check if the changed element has the class we're interested in
        if (e.target.classList.contains('package-amenities-input')) {
            const currentTarget = e.target;
            const amenitiesWrapper = currentTarget.closest('.package-amenities-wrapper');
            const btn = amenitiesWrapper.querySelector('.create-new-amenities-btn');
            createSelectedAmenties(btn.dataset.id);
        }
    });
}

const handleCustomAmenityCreate = (id) => {
    const amenityModal = document.querySelector('#modalAmenties');
    const customAmenitiesForm = amenityModal.querySelector('.custom-amenities-card-area');
    const amenityCreateButton = customAmenitiesForm.querySelector('.custom-amenities-create-button');

    // Prevent multiple event listeners
    if (amenityCreateButton.dataset.listenerAttached === 'true') return;
    amenityCreateButton.dataset.listenerAttached = 'true';

    amenityCreateButton.addEventListener('click', async (e) => {
        const amenityImageInput = customAmenitiesForm.querySelector('.custom-amenities-input');
        const amenityNameInput = customAmenitiesForm.querySelector('.custom-amenities-name-input');
        const amenityError = customAmenitiesForm.querySelector('.amenity-error');

        // Reset errors
        amenityImageInput.classList.remove('red');
        amenityNameInput.classList.remove('red');
        amenityError.textContent = '';

        // Validation
        if (!amenityImageInput.files || amenityImageInput.files.length === 0) {
            amenityImageInput.classList.add('red');
            amenityError.textContent = 'Please select an image';
            return;
        }

        if (amenityNameInput.value.trim() === '') {
            amenityNameInput.classList.add('red');
            amenityError.textContent = 'Please enter an amenity name';
            return;
        }

        // Prepare form data
        const formData = new FormData();
        formData.append('image', amenityImageInput.files[0]);
        formData.append('name', amenityNameInput.value.trim());
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        formData.append('_token', csrfToken);

        try {
            const amenity = await storeAmenities(formData);
            console.log('amenity', amenity);

            if (amenity && amenity.image && amenity.name) {
                const modalarea = document.querySelector(`.modal_area_${id}`);
                const area = modalarea.querySelector('.amenities-card-area');
                const origin = window.location.origin;

                const card = `
                    <div class="amenities-card flex gap-6" id=${Date.now()}>
                        <div class="flex gap-3" style="align-items: center;">
                            <div><img src="${origin}/uploads/amenities/${amenity.image}" alt="" width="40" height="40" /></div>
                            <div>
                                <p class="amenities-heading red">${amenity.name}</p>
                                <button class="amenties-enter-price-btn" type="button" onclick="handleClickEndterPrice(this)">Enter Price</button>
                                <div class="amenites-price-input-box flex gap-5 hidden">
                                    <span>$</span>
                                    <input type="number" class="amenites-price-input" placeholder="0.0">
                                </div>
                                <div class="amenites-price-show-box flex gap-5 hidden"></div>
                            </div>
                        </div>
                        <div class="flex h-full">
                            <button type="button" class="amenties-edit-button hidden" onclick="handleClickAddPrice(this)">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                    <g clip-path="url(#clip0_59_31)">
                                        <path d="M17.7778 0C18.3671 0 18.9324 0.234126 19.3491 0.650874C19.7659 1.06762 20 1.63285 20 2.22222V17.7778C20 18.3671 19.7659 18.9324 19.3491 19.3491C18.9324 19.7659 18.3671 20 17.7778 20H2.22222C1.63285 20 1.06762 19.7659 0.650874 19.3491C0.234126 18.9324 0 18.3671 0 17.7778V2.22222C0 1.63285 0.234126 1.06762 0.650874 0.650874C1.06762 0.234126 1.63285 0 2.22222 0H17.7778ZM15.2222 7.05556C15.4667 6.82222 15.4667 6.43333 15.2222 6.2L13.8 4.77778C13.745 4.71961 13.6786 4.67327 13.6051 4.64161C13.5315 4.60994 13.4523 4.59361 13.3722 4.59361C13.2921 4.59361 13.2129 4.60994 13.1394 4.64161C13.0658 4.67327 12.9995 4.71961 12.9444 4.77778L11.8333 5.88889L14.1111 8.16667L15.2222 7.05556ZM4.44444 13.2667V15.5556H6.73333L13.4667 8.82222L11.1778 6.53333L4.44444 13.2667Z" fill="#2F2F2F"></path>
                                    </g>
                                    <defs>
                                        <clipPath id="clip0_59_31">
                                            <rect width="20" height="20" rx="10" fill="white"></rect>
                                        </clipPath>
                                    </defs>
                                </svg>
                            </button>
                            <button type="button" class="amenties-price-submit-button" onclick="handleClickSubmitPrice(this,${id})">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M9 18C10.1819 18 11.3522 17.7672 12.4442 17.3149C13.5361 16.8626 14.5282 16.1997 15.364 15.364C16.1997 14.5282 16.8626 13.5361 17.3149 12.4442C17.7672 11.3522 18 10.1819 18 9C18 7.8181 17.7672 6.64778 17.3149 5.55585C16.8626 4.46392 16.1997 3.47177 15.364 2.63604C14.5282 1.80031 13.5361 1.13738 12.4442 0.685084C11.3522 0.232792 10.1819 -1.76116e-08 9 0C6.61305 3.55683e-08 4.32387 0.948211 2.63604 2.63604C0.948212 4.32387 0 6.61305 0 9C0 11.3869 0.948212 13.6761 2.63604 15.364C4.32387 17.0518 6.61305 18 9 18ZM8.768 12.64L13.768 6.64L12.232 5.36L7.932 10.519L5.707 8.293L4.293 9.707L7.293 12.707L8.067 13.481L8.768 12.64Z" fill="#008232"></path>
                                </svg>
                            </button>
                            <button type="button" class="amenties-price-delete-button hidden" onclick="handleClickRemovePrice(this,${id})">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                    <g clip-path="url(#clip0_24_1581)">
                                        <path d="M2.92984 17.07C1.97473 16.1475 1.21291 15.044 0.688821 13.824C0.164731 12.604 -0.111131 11.2918 -0.122669 9.96397C-0.134207 8.63618 0.11881 7.31938 0.621618 6.09042C1.12443 4.86145 1.86696 3.74493 2.80589 2.80601C3.74481 1.86708 4.86133 1.12455 6.09029 0.62174C7.31926 0.118932 8.63605 -0.134085 9.96385 -0.122547C11.2916 -0.111009 12.6038 0.164853 13.8239 0.688943C15.0439 1.21303 16.1474 1.97486 17.0698 2.92996C18.8914 4.81598 19.8994 7.342 19.8766 9.96397C19.8538 12.5859 18.8021 15.0941 16.948 16.9481C15.0939 18.8022 12.5858 19.8539 9.96385 19.8767C7.34188 19.8995 4.81586 18.8915 2.92984 17.07ZM11.3998 9.99996L14.2298 7.16996L12.8198 5.75996L9.99984 8.58996L7.16984 5.75996L5.75984 7.16996L8.58984 9.99996L5.75984 12.83L7.16984 14.24L9.99984 11.41L12.8298 14.24L14.2398 12.83L11.4098 9.99996H11.3998Z" fill="#BD191F"></path>
                                    </g>
                                    <defs>
                                        <clipPath id="clip0_24_1581">
                                            <rect width="20" height="20" fill="white"></rect>
                                        </clipPath>
                                    </defs>
                                </svg>
                            </button>
                        </div>
                    </div>
                `;

                area.insertAdjacentHTML('beforeend', card);

                // Clear inputs
                amenityImageInput.value = '';
                amenityNameInput.value = '';
            } else {
                amenityError.textContent = 'Something went wrong! Please try again';
            }
        } catch (err) {
            console.error(err);
            amenityError.textContent = 'Something went wrong! Please try again';
        }
    });
};


document.addEventListener('DOMContentLoaded', function() {
    handleAmenityInputChange();
})



// <div class="flex gap-2 mt-1" style="align-items: center;">
//     <div>
//         <svg xmlns="http://www.w3.org/2000/svg" width="53" height="52"
//             viewBox="0 0 53 52" fill="none">
//             <path
//                 d="M7 14.625C7 12.4701 7.85602 10.4035 9.37976 8.87976C10.9035 7.35602 12.9701 6.5 15.125 6.5H37.875C40.0299 6.5 42.0965 7.35602 43.6202 8.87976C45.144 10.4035 46 12.4701 46 14.625V37.375C46 39.5299 45.144 41.5965 43.6202 43.1202C42.0965 44.644 40.0299 45.5 37.875 45.5H15.125C12.9701 45.5 10.9035 44.644 9.37976 43.1202C7.85602 41.5965 7 39.5299 7 37.375V14.625Z"
//                 fill="url(#paint0_radial_24_1247)" />
//             <path
//                 d="M44.6547 41.8567C43.9138 42.977 42.9068 43.8962 41.7237 44.532C40.5406 45.1678 39.2183 45.5003 37.8752 45.4999H15.1252C13.7821 45.5003 12.4598 45.1678 11.2767 44.532C10.0936 43.8962 9.08657 42.977 8.3457 41.8567L22.5937 27.6087C23.6298 26.5727 25.035 25.9907 26.5002 25.9907C27.9654 25.9907 29.3706 26.5727 30.4067 27.6087L44.6547 41.8567Z"
//                 fill="url(#paint1_linear_24_1247)" />
//             <path
//                 d="M37.8748 17.8815C37.8748 18.7452 37.5317 19.5735 36.921 20.1842C36.3103 20.7949 35.482 21.138 34.6183 21.138C33.7546 21.138 32.9263 20.7949 32.3156 20.1842C31.7049 19.5735 31.3618 18.7452 31.3618 17.8815C31.3618 17.0178 31.7049 16.1895 32.3156 15.5788C32.9263 14.9681 33.7546 14.625 34.6183 14.625C35.482 14.625 36.3103 14.9681 36.921 15.5788C37.5317 16.1895 37.8748 17.0178 37.8748 17.8815Z"
//                 fill="url(#paint2_linear_24_1247)" />
//             <defs>
//                 <radialGradient id="paint0_radial_24_1247" cx="0" cy="0"
//                     r="1" gradientUnits="userSpaceOnUse"
//                     gradientTransform="translate(-8.3205 -15.4375) rotate(51.6869) scale(107.842 98.0889)">
//                     <stop offset="0.338" stop-color="#0FAFFF" />
//                     <stop offset="0.529" stop-color="#367AF2" />
//                 </radialGradient>
//                 <linearGradient id="paint1_linear_24_1247" x1="20.9297"
//                     y1="25.9902" x2="25.1092" y2="46.6277"
//                     gradientUnits="userSpaceOnUse">
//                     <stop stop-color="#B3E0FF" />
//                     <stop offset="1" stop-color="#8CD0FF" />
//                 </linearGradient>
//                 <linearGradient id="paint2_linear_24_1247" x1="33.3151"
//                     y1="13.9002" x2="35.6941" y2="22.4673"
//                     gradientUnits="userSpaceOnUse">
//                     <stop stop-color="#FDFDFD" />
//                     <stop offset="1" stop-color="#B3E0FF" />
//                 </linearGradient>
//             </defs>
//         </svg>
//     </div>
//     <div>
//         <button type="button"
//             class="custom-amenities-icon-upload-btn">Upload
//             Icon</button>
//     </div>
