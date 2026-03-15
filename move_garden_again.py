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

# Delete garden from original
del lines[garden_start:garden_end+1]

rooms_start = -1
for i, line in enumerate(lines):
    if '<section id="rooms"' in line:
        rooms_start = i
        break

if rooms_start == -1:
    print('Rooms start not found')
    sys.exit(1)

rooms_end = -1
for i in range(rooms_start, len(lines)):
    if lines[i].startswith('    </section>'):
        rooms_end = i
        break

if rooms_end == -1:
    print('Rooms end not found')
    sys.exit(1)

lines = lines[:rooms_end+1] + ['\n'] + garden_block + ['\n'] + lines[rooms_end+1:]

with open(file_path, 'w', encoding='utf-8') as f:
    f.writelines(lines)
    
print('Move complete!')
