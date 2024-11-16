<script setup>

import AppLayout from "@/components/Layouts/AppLayout.vue";
import Button from "@/components/Button.vue";
</script>

<template>
    <AppLayout>
        <section>
            <div class="flex gap-3">
                <div class="w-3/4">
                    <div class="ml-3 bg-white shadow-md rounded-xl mb-5">
                        <div>
                            <img class="h-48 w-full object-none rounded-t-xl" src="https://images.pexels.com/photos/8821913/pexels-photo-8821913.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1" alt="">
                        </div>
                        <div class="-mt-20 relative">
                            <img class="w-36 h-36 border-4 relative z-20 border-stone-200 rounded-full object-cover ml-6" src="https://img.freepik.com/free-photo/young-bearded-man-with-striped-shirt_273609-5677.jpg?t=st=1719294075~exp=1719297675~hmac=54f560ae2ef89547c1495370c505a8224ee1bdda400bb35863ac2c2f9c2431a0&w=740" alt="">
                               <span class="absolute bottom-7 left-40">
                                  <Icon name="material-symbols:award-star" class="text-green-600 text-xl" />
                               </span>
                            <h2 class="text-xl font-bold px-10 pt-4">John Smith</h2>
                            <p class="text-sm font-medium ml-10 pb-6 text-gray-500">Manager, CTP</p>
                            <div class="absolute right-10 bottom-10">
                                <Button class="text-sm shadow-lg">Update Profile</Button>
                            </div>
                        </div>
                    </div>
                    <div class="ml-3 bg-white shadow-md rounded-xl mt-10">
                        <h2 class="text-lg font-semibold p-4">About</h2>
                        <p class="text-sm font-medium pb-4 px-4 text-gray-500">am a person who is positive about every aspect of life. There are many things I like to do, to see, and to experience. I like to read, I like to write; I like to think, I like to dream; I like to talk, I like to listen. I like to see the sunrise in the morning, I like to see the moonlight at night; I like to feel the music flowing on my face, I like to smell the wind coming from the ocean. I like to look at the clouds in the sky with a blank mind, I like to do thought experiment when I cannot sleep in the middle of the night. I like flowers in spring, rain in summer, leaves in autumn, and snow in winter</p>
                    </div>

                </div>

                <div class="w-1/4">
                    <div class="px-5 py-3 bg-white shadow-md rounded-lg">
                        <h2 class="font-bold text-xl border-b-2 pb-3">Intro</h2>
                        <ul class="pt-3">
                            <li class="flex gap-3">
                                <span>
                                     <Icon name="material-symbols:business-center-sharp" class="text-gray-400 text-md" />
                                </span>
                                <p class="text-sm font-normal text-gray-400">Manager, CTP</p>
                            </li>
                            <li class="flex gap-3 pt-2">
                                <span>
                                     <Icon name="material-symbols:call" class="text-gray-400 text-md" />
                                </span>
                                <p class="text-sm font-normal text-gray-400">01998 4332 3423</p>
                            </li>
                            <li class="flex gap-3 pt-2">
                                <span>
                                     <Icon name="material-symbols:call" class="text-gray-400 text-md" />
                                </span>
                                <p class="text-sm font-normal text-gray-400">09982 3445 1243</p>
                            </li>
                            <li class="flex gap-3 pt-2">
                                <span>
                                     <Icon name="material-symbols:outgoing-mail" class="text-gray-400 text-md" />
                                </span>
                                <p class="text-sm font-normal text-gray-400">creative@gmail.com</p>
                            </li>
                            <li class="flex gap-3 pt-2">
                                <span>
                                     <Icon name="material-symbols:outgoing-mail" class="text-gray-400 text-md" />
                                </span>
                                <p class="text-sm font-normal text-gray-400">ctp@gmail.com</p>
                            </li>
                            <li class="flex gap-3 pt-2">
                                <span>
                                     <Icon name="material-symbols:pin-drop" class="text-gray-400 text-md" />
                                </span>
                                <p class="text-sm font-normal text-gray-400">Merul Badda, Dhaka, Bangladesh</p>
                            </li>

                        </ul>

                    </div>
                </div>
            </div>
        </section>
    </AppLayout>
</template>

<style scoped>

</style>
