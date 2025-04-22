// Enhanced AI chat functionality for SurabayaAI
document.addEventListener("DOMContentLoaded", () => {
    // DOM Elements
    const chatContainer = document.getElementById("chat-messages")
    const chatForm = document.getElementById("chat-form")
    const chatInput = document.getElementById("chat-input")
    const sendButton = document.getElementById("send-button")
    const topicButtons = document.querySelectorAll(".topic-btn")
  
    // Knowledge base for Surabaya history
    const knowledgeBase = {
      "battle of surabaya":
        "The Battle of Surabaya took place on November 10, 1945. It was a fight between Indonesian nationalists and British-Indian troops as part of the Indonesian National Revolution. This battle is commemorated as Heroes' Day (Hari Pahlawan) in Indonesia. The battle began after British forces landed in Surabaya in late October 1945 with the intent to disarm Japanese troops and liberate European internees. Tensions escalated when British Brigadier Mallaby was killed on October 30, leading to an ultimatum from the British. When Indonesian forces refused to surrender, the British launched a major assault using air, naval, and land forces.",
  
      "bung tomo":
        "Sutomo, better known as Bung Tomo, was a prominent Indonesian independence activist who played a significant role during the Battle of Surabaya. His fiery radio broadcasts inspired the people of Surabaya to fight against British-Indian troops. Born on October 3, 1920, Bung Tomo was known for his charismatic leadership and powerful oratory skills. His famous speech on November 10, 1945, rallied the people of Surabaya with the battle cry 'Merdeka atau Mati!' (Freedom or Death!). After independence, he remained active in politics but often found himself at odds with the government. He passed away on October 7, 1981, and was posthumously declared a National Hero of Indonesia in 2008.",
  
      "surabaya name":
        "The name 'Surabaya' is believed to come from the words 'sura' (shark) and 'baya' (crocodile), referring to a legendary battle between these creatures that symbolizes the Mongol forces and Raden Wijaya's Majapahit forces in ancient times. According to the legend, the shark (representing the naval forces) and the crocodile (representing the land forces) fought fiercely in what is now the Kalimas River. This epic battle became a symbol of courage and determination, qualities that the city of Surabaya is known for. The city's coat of arms features these two animals, commemorating this founding legend.",
  
      "historical sites":
        "Surabaya has many historical sites including the Heroes Monument (Tugu Pahlawan), Hotel Majapahit (formerly Hotel Oranje), Submarine Monument (Monumen Kapal Selam), and the House of Sampoerna, which showcase different periods of the city's rich history. Other notable sites include the Ampel Mosque and Tomb (one of the oldest mosques in Indonesia), Jembatan Merah (Red Bridge, a site of historical battles), Grahadi Building (the governor's residence since Dutch colonial times), and the Surabaya Zoo (one of the oldest zoos in the world, established in 1916).",
  
      independence:
        "Surabaya played a crucial role in Indonesia's fight for independence. The Battle of Surabaya on November 10, 1945, became a symbol of Indonesian resistance against colonial powers and is now commemorated as Heroes' Day. The city was a hotbed of nationalist sentiment and revolutionary activity. After the Japanese surrender at the end of World War II, young Indonesians in Surabaya seized weapons and took control of public buildings. When Allied forces arrived to disarm Japanese troops, tensions escalated into the famous battle that demonstrated Indonesia's determination to defend its newly proclaimed independence.",
  
      "tugu pahlawan":
        "Tugu Pahlawan (Heroes Monument) is a 41.15 meter tall monument in Surabaya built to commemorate the heroes who fell during the Battle of Surabaya on November 10, 1945. It's one of the most important historical landmarks in the city. The monument was built on the site of the former Raad van Justitie (Dutch colonial court) that was destroyed during the battle. Construction began in 1951 and was completed in 1952. The monument's height, 41.15 meters, symbolizes the date of the battle (10-11-'45). A museum was later added to the complex, displaying artifacts and information about Indonesia's struggle for independence.",
  
      "hotel majapahit":
        "Hotel Majapahit, formerly known as Hotel Oranje during Dutch colonial times, is a historic luxury hotel in Surabaya. It gained historical significance when young Indonesian revolutionaries tore down the Dutch flag and raised the Indonesian flag during the independence struggle. This incident, known as the 'Hotel Yamato Incident' (as it was called Hotel Yamato during Japanese occupation), occurred on September 19, 1945. The hotel was built in 1910 by the Sarkies Brothers, who also built the famous Raffles Hotel in Singapore. Today, it stands as a preserved colonial landmark, combining historical significance with luxury accommodation.",
  
      "submarine monument":
        "The Submarine Monument (Monumen Kapal Selam) displays the KRI Pasopati 410, a Soviet-built Whiskey-class submarine that served in the Indonesian Navy. It's now a museum where visitors can explore inside the submarine. The submarine was in active service from 1962 until 1990. After decommissioning, it was installed as a monument in 1995. The 76-meter long submarine is displayed on dry land and has been cut in several places to allow visitors to walk through and experience what life was like for submariners. The monument is located on Jalan Pemuda, one of Surabaya's main streets.",
  
      "house of sampoerna":
        "The House of Sampoerna is a tobacco museum and headquarters of Sampoerna cigarettes. The Dutch colonial-style building was built in 1862 and now showcases the history of Sampoerna and tobacco production in Indonesia. Originally used as an orphanage managed by the Dutch, it was purchased by Liem Seeng Tee, the founder of Sampoerna, in 1932. The complex includes a museum, art gallery, cafe, and a functioning cigarette factory where visitors can observe traditional hand-rolling methods. The museum displays antique cigarette packaging, advertising materials, and the family history of the Sampoerna business.",
  
      "cheng ho":
        "Admiral Cheng Ho (or Zheng He) was a Chinese explorer who visited Surabaya during his voyages in the early 15th century. His visits contributed to the spread of Islam and Chinese cultural influence in the region. Cheng Ho was a Muslim Chinese admiral who led seven major expeditions on behalf of the Ming Dynasty between 1405 and 1433. His fleet visited Surabaya, which was already a significant port city. A temple dedicated to Cheng Ho (Sam Po Kong Temple) can be found in the Chinatown area of Surabaya, indicating his lasting influence. His voyages helped establish trade networks and cultural exchanges between China and the Indonesian archipelago.",
  
      "ampel mosque":
        "The Ampel Mosque is one of the oldest mosques in Indonesia, built by Sunan Ampel (Raden Rahmat), one of the Wali Songo (Nine Saints) who spread Islam in Java. The mosque and surrounding area remain an important religious and historical site. Sunan Ampel arrived in Java in the 15th century and established a pesantren (Islamic boarding school) in what is now the Ampel area of Surabaya. The mosque was built around 1421 and has been renovated several times while maintaining its historical character. The surrounding Ampel district is a vibrant Arab quarter with narrow streets, Islamic bookshops, perfume stalls, and food vendors, creating a unique cultural enclave in the city.",
  
      kalimas:
        "Kalimas River is historically significant as it was the main transportation route that helped Surabaya develop as a major port city. Many of the city's oldest settlements and buildings are located along this river. The name 'Kalimas' means 'river of gold,' indicating its importance to the city's economy and development. During colonial times, the river was a busy commercial waterway with warehouses and trading offices lining its banks. Today, while its commercial importance has diminished, efforts are being made to revitalize the riverfront areas. The legendary battle between the shark (sura) and crocodile (baya) that gave the city its name is said to have taken place in this river.",
  
      "majapahit empire":
        "Surabaya had significant connections to the Majapahit Empire, one of the greatest Indonesian empires that ruled much of the archipelago from 1293 to around 1500. According to historical records, Surabaya was an important port city for the empire. The founder of Majapahit, Raden Wijaya, used the area around Surabaya as a base during his conflict with the Mongol forces sent by Kublai Khan in 1293. The legendary battle between the shark and crocodile that gave Surabaya its name is often associated with this historical conflict. After the fall of Majapahit, Surabaya became an independent duchy before eventually coming under Dutch colonial control in the 18th century.",
  
      "heroes day":
        "Heroes Day (Hari Pahlawan) is celebrated annually on November 10th to commemorate the Battle of Surabaya in 1945. This national holiday honors those who fought and died in the battle against British forces, which became a symbol of Indonesian resistance during the independence struggle. The battle began after the killing of British Brigadier Mallaby and a subsequent British ultimatum to the Indonesian fighters. Despite being outgunned, the Indonesians fought bravely, and though they eventually lost the battle, their resistance inspired the nation. The date was officially designated as Heroes Day by President Sukarno in 1946, making it one of Indonesia's most important national observances.",
  
      "red bridge":
        "Jembatan Merah (Red Bridge) is a historic bridge in Surabaya that played a significant role during the independence struggle. The bridge, painted red, spans the Kalimas River and connects the commercial area with the old town. It was the site of fierce fighting during the Battle of Surabaya in 1945. The bridge is mentioned in a famous Indonesian patriotic song 'Surabaya Oh Surabaya,' which includes lyrics about the Red Bridge. Today, while the current structure is not the original bridge, it remains an important historical landmark and symbol of the city's revolutionary past.",
  
      default:
        "I don't have specific information about that aspect of Surabaya's history. Would you like to know about the Battle of Surabaya, historical sites, or the origin of Surabaya's name instead?",
    }
  
    // Add event listeners
    chatForm.addEventListener("submit", handleSubmit)
  
    // Add event listeners to topic buttons
    topicButtons.forEach((button) => {
      button.addEventListener("click", () => {
        const topic = button.getAttribute("data-topic")
        if (topic) {
          chatInput.value = topic
          handleSubmit(new Event("submit"))
        }
      })
    })
  
    // Handle form submission
    function handleSubmit(e) {
      e.preventDefault()
      const message = chatInput.value.trim()
      if (message) {
        addMessage("user", message)
        chatInput.value = ""
        processMessage(message)
      }
    }
  
    // Process user message and generate response
    function processMessage(message) {
      // Show typing indicator
      showTypingIndicator()
  
      // Find response in knowledge base
      const response = findResponse(message.toLowerCase())
  
      // Simulate AI thinking time (between 1-3 seconds based on response length)
      const thinkingTime = Math.min(1000 + response.length / 10, 3000)
  
      setTimeout(() => {
        // Remove typing indicator
        removeTypingIndicator()
  
        // Add AI response with typing effect
        addMessage("ai", response, true)
  
        // Scroll to bottom
        scrollToBottom()
      }, thinkingTime)
    }
  
    // Find appropriate response from knowledge base
    function findResponse(message) {
      // Check for keywords in the message
      for (const [keyword, response] of Object.entries(knowledgeBase)) {
        if (message.includes(keyword)) {
          return response
        }
      }
  
      // Check for question types
      if (
        message.includes("who") ||
        message.includes("what") ||
        message.includes("when") ||
        message.includes("where") ||
        message.includes("why") ||
        message.includes("how") ||
        message.includes("tell") ||
        message.includes("explain")
      ) {
        return knowledgeBase.default
      }
  
      // Default response for greetings
      if (
        message.includes("hello") ||
        message.includes("hi") ||
        message.includes("hey") ||
        message.includes("greetings")
      ) {
        return "Hello! I'm SurabayaAI. How can I help you learn about Surabaya's history today? You can ask me about the Battle of Surabaya, historical sites, or the origin of Surabaya's name."
      }
  
      // Thank you responses
      if (message.includes("thank") || message.includes("thanks") || message.includes("appreciate")) {
        return "You're welcome! I'm happy to help you learn about Surabaya's rich history. Is there anything else you'd like to know?"
      }
  
      // Default response
      return "I'm not sure I understand. Could you ask about a specific aspect of Surabaya's history? For example, you can ask about the Battle of Surabaya, historical sites, or the origin of Surabaya's name."
    }
  
    // Add message to chat
    function addMessage(sender, message, withTyping = false) {
      const messageElement = document.createElement("div")
      messageElement.classList.add("mb-4", "message-animation")
  
      const timestamp = new Date().toLocaleTimeString([], { hour: "2-digit", minute: "2-digit" })
  
      if (sender === "user") {
        messageElement.innerHTML = `
          <div class="flex items-start justify-end">
            <div class="bg-red-100 rounded-lg p-3 shadow-sm max-w-[80%]">
              <p class="text-gray-800">${message}</p>
              <p class="text-xs text-gray-500 text-right mt-1">${timestamp}</p>
            </div>
            <div class="w-8 h-8 rounded-full bg-red-500 flex items-center justify-center text-white ml-2">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
              </svg>
            </div>
          </div>
        `
      } else {
        messageElement.innerHTML = `
          <div class="flex items-start">
            <div class="w-8 h-8 rounded-full bg-red-100 flex items-center justify-center text-red-600 mr-2">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
              </svg>
            </div>
            <div class="bg-white rounded-lg p-3 shadow-sm max-w-[80%]">
              <p class="text-gray-800">
                ${withTyping ? `<span class="typing-animation"><span class="typing-text">${message}</span></span>` : message}
              </p>
              <p class="text-xs text-gray-500 mt-1">${timestamp}</p>
            </div>
          </div>
        `
      }
  
      chatContainer.appendChild(messageElement)
      scrollToBottom()
  
      // Initialize typing animation if needed
      if (withTyping && sender === "ai") {
        const typingText = messageElement.querySelector(".typing-text")
        if (typingText) {
          animateTyping(typingText, message)
        }
      }
    }
  
    // Animate typing effect
    function animateTyping(element, text) {
      let i = 0
      element.textContent = ""
  
      function type() {
        if (i < text.length) {
          element.textContent += text.charAt(i)
          i++
  
          // Random typing speed for more realistic effect
          const randomSpeed = Math.floor(Math.random() * 10) + 20
          setTimeout(type, randomSpeed)
  
          // Scroll as typing happens
          scrollToBottom()
        }
      }
  
      type()
    }
  
    // Show typing indicator
    function showTypingIndicator() {
      const typingElement = document.createElement("div")
      typingElement.id = "typing-indicator"
      typingElement.classList.add("mb-4", "message-animation")
      typingElement.innerHTML = `
        <div class="flex items-start">
          <div class="w-8 h-8 rounded-full bg-red-100 flex items-center justify-center text-red-600 mr-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
            </svg>
          </div>
          <div class="bg-white rounded-lg p-3 shadow-sm">
            <div class="flex space-x-2">
              <div class="w-2 h-2 bg-red-400 rounded-full animate-bounce" style="animation-delay: 0ms;"></div>
              <div class="w-2 h-2 bg-red-400 rounded-full animate-bounce" style="animation-delay: 150ms;"></div>
              <div class="w-2 h-2 bg-red-400 rounded-full animate-bounce" style="animation-delay: 300ms;"></div>
            </div>
          </div>
        </div>
      `
      chatContainer.appendChild(typingElement)
      scrollToBottom()
    }
  
    // Remove typing indicator
    function removeTypingIndicator() {
      const typingIndicator = document.getElementById("typing-indicator")
      if (typingIndicator) {
        typingIndicator.remove()
      }
    }
  
    // Scroll chat to bottom
    function scrollToBottom() {
      chatContainer.scrollTop = chatContainer.scrollHeight
    }
  
    // Add initial welcome message
    setTimeout(() => {
      addMessage(
        "ai",
        "Hello! I'm SurabayaAI, your guide to Surabaya's rich history. What would you like to know about Surabaya today?",
        true,
      )
    }, 1000)
  })
  