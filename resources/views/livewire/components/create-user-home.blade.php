<section id="register" class="bg-indigo-600 py-16 px-6">
    <div class="max-w-lg mx-auto bg-white rounded-xl shadow-lg p-8">
        <h2 class="text-3xl font-bold text-center mb-6 text-gray-900">Buat Akun Sepakat-AI</h2>
        <form class="space-y-6" action="#" wire:submit="store">
            <div>
                <label for="name" class="block text-gray-700 font-semibold mb-1">Nama Lengkap</label>
                <input wire:model="name" type="text" id="name" name="name" required
                    class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition"
                    placeholder="Nama Anda" />
                    <div>
                        @error('name')
                            <p class="text-red-500">{{$message}}</p>
                        @enderror
                    </div>
            </div>
            <div>
                <label for="email" class="block text-gray-700 font-semibold mb-1">Email</label>
                <input wire:model="email" type="email" id="email" name="email" required
                    class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition"
                    placeholder="email@domain.com" />
                    <div>
                        @error('email')
                            <p class="text-red-500">{{$message}}</p>
                        @enderror
                    </div>
            </div>
            <div>
                <label for="password" class="block text-gray-700 font-semibold mb-1">Kata Sandi</label>
                <input wire:model="password" type="password" id="password" name="password" required
                    class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition"
                    placeholder="Minimal 8 karakter" minlength="8" />
                    <div>
                        @error('password')
                            <p class="text-red-500">{{$message}}</p>
                        @enderror
                    </div>
            </div>
            <button type="submit"
                class="w-full bg-indigo-600 text-white font-semibold rounded-lg py-3 hover:bg-indigo-700 transition">
                Daftar Akun
            </button>
        </form>
    </div>
</section>
