var amenitesData = []

function handleOpenCustomAmenties() {
    let a = document.querySelector('.custom-amenities-card-area')
    let b = document.querySelector('.create-custom-amenities-btn')
    if (a.classList.value.includes('hidden')) {
        a.classList.remove('hidden')
        b.innerText = 'Cancel Custom Amenities'
    }
    else {
        a.classList.add('hidden')
        b.innerText = 'Create Custom Amenities'
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
function handleClickSubmitPrice(element) {
    const card = element.closest('.amenities-card');
    let value = card.querySelector('.amenites-price-input').value
    let name = card.querySelector('.amenities-heading').innerText
    if (value !== '') {
        card.classList.add('red')
        card.querySelector('.amenites-price-input-box').classList.add('hidden');
        card.querySelector('.amenties-price-submit-button').classList.add('hidden');
        card.querySelector('.amenites-price-show-box').classList.remove('hidden');
        card.querySelector('.amenties-price-delete-button').classList.remove('hidden');
        card.querySelector('.amenites-price-show-box').innerHTML = `<span>$ ${value}</span>`;
        amenitesData.push({ name: name, parice: value })
    }
    else {
        card.querySelector('.amenites-price-input-box').classList.add('red');
    }
}
function handleClickRemovePrice(element) {
    const card = element.closest('.amenities-card');
    card.querySelector('.amenites-price-show-box').classList.add('hidden');
    card.querySelector('.amenties-price-delete-button').classList.add('hidden');
    card.classList.remove('red')
    card.querySelector('.amenties-edit-button').classList.remove('hidden');
    card.querySelector('.amenities-heading').classList.remove('red');
    card.querySelector('.amenites-price-input-box').classList.remove('red');
    card.querySelector('.amenites-price-input').value = ''
    let name = card.querySelector('.amenities-heading').innerText
    amenitesData = amenitesData.filter(item => item.name !== name);
}

function handleCreateCustomAmenties() {
    let value = document.querySelector('.custom-amenities-name-input')
    let area = document.querySelector('.amenities-card-area')
    if (value.value === '') {
        value.classList.add('red')
    }
    else {
        value.classList.remove('red')
        let card = `
                                                <div class="amenities-card flex gap-6">
                                                    <div class="flex gap-3" style="align-items: center;">
                                                        <div>
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="41" viewBox="0 0 40 41" fill="none">
                                                                <g clip-path="url(#clip0_59_27)">
                                                                    <path d="M35.6354 0.504243C35.6354 0.504243 4.51559 0.494697 4.52515 0.504243C1.66173 0.504243 0 1.98255 0 5.00344V36.1459C0 38.9721 1.58654 40.5 4.44805 40.5H35.7609C38.6218 40.5 40 39.0459 40 36.1459V5.00344C40 2.05637 38.5861 0.504243 35.6354 0.504243ZM18.3013 37.0152C15.4379 37.0152 12.7459 35.9015 10.7216 33.8798C9.72322 32.8878 8.93166 31.708 8.3927 30.4086C7.85374 29.1091 7.57807 27.7159 7.58164 26.3094C7.58368 24.4106 8.09023 22.5463 9.04957 20.9069C10.0089 19.2675 11.3867 17.9118 13.0421 16.9782L13.9686 18.6188C12.6043 19.3884 11.4688 20.5058 10.6781 21.8569C9.88734 23.208 9.46966 24.7444 9.46765 26.3094C9.46469 27.4684 9.69179 28.6165 10.1358 29.6873C10.5798 30.758 11.232 31.7303 12.0545 32.5478C12.8729 33.3698 13.8464 34.0215 14.9187 34.4651C15.9909 34.9087 17.1407 35.1355 18.3013 35.1321C20.2863 35.1381 22.2151 34.4738 23.7745 33.2471C25.3339 32.0204 26.4324 30.3032 26.8916 28.3744L28.7253 28.8135C28.1684 31.1544 26.8354 33.2385 24.943 34.7274C23.0505 36.2163 20.7104 37.0225 18.3013 37.0152ZM32.8312 33.069L32.0475 33.3821L31.6493 32.7139L26.4934 23.1625H15.1327L15.0409 22.2468L13.3894 7.00358L13.4111 6.98258C13.2522 6.55716 13.1921 6.10128 13.2352 5.64929C13.2783 5.19729 13.4235 4.76096 13.6599 4.37314C13.8963 3.98533 14.2178 3.65614 14.6 3.41037C14.9823 3.16461 15.4154 3.00867 15.8667 2.9543C16.2577 2.90754 16.6541 2.93816 17.0333 3.04441C17.4124 3.15066 17.7669 3.33046 18.0765 3.57354C18.3861 3.81662 18.6447 4.11822 18.8376 4.46112C19.0305 4.80403 19.1539 5.18152 19.2007 5.57204C19.2475 5.96257 19.2168 6.35848 19.1105 6.73717C19.0041 7.11586 18.8241 7.46992 18.5807 7.77912C18.3373 8.08833 18.0353 8.34663 17.692 8.53927C17.3487 8.73192 16.9707 8.85514 16.5797 8.9019C16.2147 8.94456 15.8449 8.91975 15.4889 8.82871L16.3153 15.9905L24.9068 15.9937V17.878L16.5204 17.9487L16.8263 21.2782H27.6243L27.8913 21.7014L32.9154 31.0447L34.8823 30.2403L35.5825 31.9795L32.8312 33.069Z" fill="#3B3B3B"></path>
                                                                </g>
                                                                <defs>
                                                                    <clipPath id="clip0_59_27">
                                                                        <rect width="40" height="40" fill="white" transform="translate(0 0.5)"></rect>
                                                                    </clipPath>
                                                                </defs>
                                                            </svg>
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
                                                        <button type="button" class="amenties-price-submit-button hidden" onclick="handleClickSubmitPrice(this)">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
                                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M9 18C10.1819 18 11.3522 17.7672 12.4442 17.3149C13.5361 16.8626 14.5282 16.1997 15.364 15.364C16.1997 14.5282 16.8626 13.5361 17.3149 12.4442C17.7672 11.3522 18 10.1819 18 9C18 7.8181 17.7672 6.64778 17.3149 5.55585C16.8626 4.46392 16.1997 3.47177 15.364 2.63604C14.5282 1.80031 13.5361 1.13738 12.4442 0.685084C11.3522 0.232792 10.1819 -1.76116e-08 9 0C6.61305 3.55683e-08 4.32387 0.948211 2.63604 2.63604C0.948212 4.32387 0 6.61305 0 9C0 11.3869 0.948212 13.6761 2.63604 15.364C4.32387 17.0518 6.61305 18 9 18ZM8.768 12.64L13.768 6.64L12.232 5.36L7.932 10.519L5.707 8.293L4.293 9.707L7.293 12.707L8.067 13.481L8.768 12.64Z" fill="#008232"></path>
                                                            </svg>
                                                        </button>
                                                        <button type="button" class="amenties-price-delete-button hidden" onclick="handleClickRemovePrice(this)">
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

    }
    console.log(value)
}

function handleSaveAmenties() {
    let a = document.querySelector('#modalAmenties').classList.add('hidden')
    createSelectedAmenties()
}

function createSelectedAmenties() {
    console.log(amenitesData)
    let b = document.querySelector('.selected-amenties-area')
    b.innerHTML = ''
    console.log(b)
    amenitesData.forEach(item => {

        let card = `
                                               <div class="amenities-card flex gap-6 red">
                                                    <div class="flex gap-3" style="align-items: center;">
                                                        <div>
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="41" viewBox="0 0 40 41" fill="none">
                                                                <g clip-path="url(#clip0_59_27)">
                                                                    <path d="M35.6354 0.504243C35.6354 0.504243 4.51559 0.494697 4.52515 0.504243C1.66173 0.504243 0 1.98255 0 5.00344V36.1459C0 38.9721 1.58654 40.5 4.44805 40.5H35.7609C38.6218 40.5 40 39.0459 40 36.1459V5.00344C40 2.05637 38.5861 0.504243 35.6354 0.504243ZM18.3013 37.0152C15.4379 37.0152 12.7459 35.9015 10.7216 33.8798C9.72322 32.8878 8.93166 31.708 8.3927 30.4086C7.85374 29.1091 7.57807 27.7159 7.58164 26.3094C7.58368 24.4106 8.09023 22.5463 9.04957 20.9069C10.0089 19.2675 11.3867 17.9118 13.0421 16.9782L13.9686 18.6188C12.6043 19.3884 11.4688 20.5058 10.6781 21.8569C9.88734 23.208 9.46966 24.7444 9.46765 26.3094C9.46469 27.4684 9.69179 28.6165 10.1358 29.6873C10.5798 30.758 11.232 31.7303 12.0545 32.5478C12.8729 33.3698 13.8464 34.0215 14.9187 34.4651C15.9909 34.9087 17.1407 35.1355 18.3013 35.1321C20.2863 35.1381 22.2151 34.4738 23.7745 33.2471C25.3339 32.0204 26.4324 30.3032 26.8916 28.3744L28.7253 28.8135C28.1684 31.1544 26.8354 33.2385 24.943 34.7274C23.0505 36.2163 20.7104 37.0225 18.3013 37.0152ZM32.8312 33.069L32.0475 33.3821L31.6493 32.7139L26.4934 23.1625H15.1327L15.0409 22.2468L13.3894 7.00358L13.4111 6.98258C13.2522 6.55716 13.1921 6.10128 13.2352 5.64929C13.2783 5.19729 13.4235 4.76096 13.6599 4.37314C13.8963 3.98533 14.2178 3.65614 14.6 3.41037C14.9823 3.16461 15.4154 3.00867 15.8667 2.9543C16.2577 2.90754 16.6541 2.93816 17.0333 3.04441C17.4124 3.15066 17.7669 3.33046 18.0765 3.57354C18.3861 3.81662 18.6447 4.11822 18.8376 4.46112C19.0305 4.80403 19.1539 5.18152 19.2007 5.57204C19.2475 5.96257 19.2168 6.35848 19.1105 6.73717C19.0041 7.11586 18.8241 7.46992 18.5807 7.77912C18.3373 8.08833 18.0353 8.34663 17.692 8.53927C17.3487 8.73192 16.9707 8.85514 16.5797 8.9019C16.2147 8.94456 15.8449 8.91975 15.4889 8.82871L16.3153 15.9905L24.9068 15.9937V17.878L16.5204 17.9487L16.8263 21.2782H27.6243L27.8913 21.7014L32.9154 31.0447L34.8823 30.2403L35.5825 31.9795L32.8312 33.069Z" fill="#3B3B3B"></path>
                                                                </g>
                                                                <defs>
                                                                    <clipPath id="clip0_59_27">
                                                                        <rect width="40" height="40" fill="white" transform="translate(0 0.5)"></rect>
                                                                    </clipPath>
                                                                </defs>
                                                            </svg>
                                                        </div>
                                                        <div>
                                                            <p class="amenities-heading red">${item.name}</p>

                                                            <div class="amenites-price-show-box flex gap-5"><span>$ ${item.price}</span></div>
                                                        </div>
                                                    </div>
                                                    <div class="flex h-full">
                                                        <button type="button" class="amenties-price-delete-button" onclick="handleRemoveSelectedAmenties(this)">
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
        b.insertAdjacentHTML('beforeend', card)
    })
}

function handleOpenAmentiesModal() {
    console.log('ji')
    document.querySelector('#modalAmenties').classList.remove('hidden')
}

function handleRemoveSelectedAmenties(element) {
    const card = element.closest('.amenities-card');
    let name = card.querySelector('.amenities-heading').innerText
    amenitesData = amenitesData.filter(item => item.name !== name);
    createSelectedAmenties()
}
