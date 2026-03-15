import sys

file_path = r'e:\Projects\rosevilla\rosevilla\resources\views\home.blade.php'

with open(file_path, 'r', encoding='utf-8') as f:
    lines = f.readlines()

garden_start = -1
for i, line in enumerate(lines):
    if '<section id="garden"' in line:
        garden_start = i
        break

if garden_start == -1:
    print('Garden start not found')
    sys.exit(1)

garden_end = -1
for i in range(garden_start, len(lines)):
    if '</section>' in lines[i] and not lines[i].startswith('        </section>'):
        if lines[i].startswith('    </section>'):
            garden_end = i
            break

if garden_end == -1:
    print('Garden end not found')
    sys.exit(1)

garden_block = lines[garden_start:garden_end+1]

# Insert Title
title_insertion_idx = -1
for i, line in enumerate(garden_block):
    if 'max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10' in line:
        title_insertion_idx = i
        break

if title_insertion_idx != -1:
    title_html = """            <div class="text-center mb-16">
                <span class="text-emerald-600 text-xs font-bold tracking-[0.4em] uppercase block mb-4">{{ __('Outdoor Event Space') }}</span>
                <h2 class="font-serif text-4xl md:text-6xl text-emerald-900 mb-6 uppercase tracking-tight">{{ __('Reserve the Garden') }}</h2>
                <div class="w-24 h-1 bg-gradient-to-r from-transparent via-emerald-500 to-transparent mx-auto mb-8 rounded-full"></div>
                <p class="text-gray-500 font-light text-lg max-w-2xl mx-auto leading-relaxed">
                    {{ __('Our scenic gardens provide a perfect backdrop for your most magical moments.') }}
                </p>
            </div>\n"""
    # check if already inserted
    if 'Reserve the Garden' not in garden_block[title_insertion_idx+2]:
        garden_block.insert(title_insertion_idx + 1, title_html)
    else:
        print('Title already present')

# Delete garden from original
del lines[garden_start:garden_end+1]

res_start = -1
for i, line in enumerate(lines):
    if '<section id="reservation"' in line:
        res_start = i
        break

if res_start == -1:
    print('Reservation start not found')
    sys.exit(1)

res_end = -1
for i in range(res_start, len(lines)):
    if lines[i].startswith('    </section>'):
        res_end = i
        break

if res_end == -1:
    print('Reservation end not found')
    sys.exit(1)

lines = lines[:res_end+1] + ['\n'] + garden_block + ['\n'] + lines[res_end+1:]

with open(file_path, 'w', encoding='utf-8') as f:
    f.writelines(lines)
    
print('Move complete!')
