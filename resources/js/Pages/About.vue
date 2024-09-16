<template>
     <h1 class="lg:text-blue-300 text-red-700">Welcome to my about page</h1>
     <p>What would you like to know about me</p>
     <h2 class="lg:text-[60px] text-[12px]">My name is {{ name }}</h2>
     <button @click="bringBack" class="bg-green-600 p-3 rounded-md text-[2opx]  text-white lg:hidden innitial">{{available ? "Bring back" : "Bring front"}}</button>
     <div class="flex block">
        <div :class="available? 'left-0' : 'left-[-500px]'" class="lg:w-3/12 bg-orange-500 lg:static fixed transition-all">
           <h1> Lorem, ipsum dolor.</h1>
           <h1> Lorem, ipsum dolor.</h1>
           <h1> Lorem, ipsum dolor.</h1>
           <h1> Lorem, ipsum dolor.</h1>
           <h1> Lorem, ipsum dolor.</h1>
           <h1> Lorem, ipsum dolor.</h1>
           <h1> Lorem, ipsum dolor.</h1>
        </div>
        <div class="lg:3/12 w-full bg-violet-500">
            Lorem, ipsum dolor.
        </div>
        <div class="lg:3/12 w-full bg-green-500">
            Lorem, ipsum dolor.
        </div>
        <div class="lg:3/12 w-full bg-purple-500">
            Lorem, ipsum dolor.
        </div>
     </div>
  <div class="container mx-auto py-8">
    <form :class="editingUser ? 'hidden' : 'block'" class="max-w-md mx-auto">
      <div class="mb-4">
        <label for="class" class="block text-gray-700 font-bold mb-2">Name</label>
        <input v-model="name" type="text" id="class" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
      </div>
      <div class="mb-4">
        <label for="class" class="block text-gray-700 font-bold mb-2">Class</label>
        <input v-model="classes" type="text" id="class" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
      </div>
      <div class="mb-4">
        <label for="age" class="block text-gray-700 font-bold mb-2">Age</label>
        <input v-model="age" type="number" id="age" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
      </div>
      <div class="flex items-center justify-between">
        <button @click="saveUser" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Save</button>    
      </div>
    </form>
  </div>

  <div class="container mx-auto py-8">
    <form :class="!editingUser ? 'hidden' : 'block'" class="max-w-md mx-auto">
      <div class="mb-4">
        <label for="class" class="block text-gray-700 font-bold mb-2">Name</label>
        <input v-model="editedUser.name" type="text" id="class" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
      </div>
      <div class="mb-4">
        <label for="class" class="block text-gray-700 font-bold mb-2">Class</label>
        <input v-model="editedUser.class" type="text" id="class" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
      </div>
      <div class="mb-4">
        <label for="age" class="block text-gray-700 font-bold mb-2">Age</label>
        <input v-model="editedUser.age" type="number" id="age" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
      </div>
      <div class="flex items-center justify-between">
        <button @click="saveEdit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Edit</button>
      </div>
    </form>
  </div>

  <div class=" w-full bg-red-200 h-[auto] m-[20px] ">
  <table class="w-1/2 bg-pink-200 h-[auto] m-[20px] shadow-md rounded-lg border border-gray-200">
    <thead class="text-left"> <tr>
        <th class="w-[50px] h-[40px] bg-gray-300 px-3 py-2">S/N</th> <th class="bg-gray-300 px-3 py-2">Name</th>
        <th class="bg-gray-300 px-3 py-2">Age</th>
        <th class="bg-gray-300 px-3 py-2">Class</th>
        <th  class="bg-gray-300 w-[20px] px-3 py-2">Edit</th>
        <th class="bg-gray-300 w-[20px] px-3 py-2">Delete</th>
      </tr>
    </thead>
    <tbody class="text-left"> <tr v-for="(user, index) in users" class="hover:bg-gray-100 border-b border-gray-200"> 
        <td class="px-3 py-2">{{ index + 1 }}</td>
        <td class="px-3 py-2">{{ user.name }}</td>
        <td class="px-3 py-2">{{ user.age }}</td>
        <td class="px-3 py-2">{{ user.class }}</td>
        <td class="px-3 py-2">
          <button @click="edit(index)" class="bg-green-500 text-white font-bold py-2 px-4 rounded hover:bg-green-700">Edit</button>

        </td>
        <td class="px-3 py-2">
          <button @click="clearIt(index)" class="bg-purple-500 text-white font-bold py-2 px-4 rounded hover:bg-purple-700">Del</button>
        </td>
      </tr>
    </tbody>
  </table>
</div>
<Buttonss></Buttonss>
<Card></Card>
</template>
<script>
import Buttonss from '@/Components/Buttonss.vue';
import Card from './Card.vue';
export default{
    components:{
        Buttonss, 
        Card
    },
   


    data(){
        return{
            name:"Keena",
            available:false,
            hasPaid: false,
            age: 0, 
            classes: "",
            // user:[
            //     {name:"Keena", age: 6, class:"Laravel"},
            //     {name:"Jena", age: 7, class:"vue"}
            // ],
            users: JSON.parse(localStorage.getItem('users')) || [],
            editingUser:false,
            editedUser:{},
            foundIndex:0
        }
    },
   
    methods:{
        bringBack(){
            this.available = !this.available
        },


        saveUser() {
                if (this.name===""|| this.age=== 0|| this.classes=== "") {
                alert("All input fields are mandatory")  
                }
            const newUser = {
                name: this.name,
                age: this.age,
                class: this.classes
            };

        const userExist = this.users.find(user => user.name === newUser.name);

        if (userExist) {
                alert('User already exists');
            } else {
                this.users.push(newUser);
                localStorage.setItem('users', JSON.stringify(this.users));
                alert("Success");
            }
    },

    clearIt(index){
        this.users.splice(index, 1);
        localStorage.setItem('users', JSON.stringify(this.users))
    },

    edit(index){
        this.editingUser = true
        this.editedUser = { ...this.users[index] };
        this.foundIndex = index

    },

    saveEdit() {    
        const user = this.users[this.foundIndex];
        if (user) {
            this.users[this.foundIndex] = this.editedUser
            localStorage.setItem('users', JSON.stringify(this.users));
            alert("Saved!");
        } else {
            alert("User not found!");
        }
        this.foundIndex = 0
        this.editingUser = false;
        this.editedUser = {};
    }

    },
    mounted(){

    },
    created(){},
    beforeCreate(){},
    beforeCreate(){}

}

</script>