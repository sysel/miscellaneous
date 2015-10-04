# Linux From Scratch

## Environment setup

### Create drive
Add 40GB drive
```
sudo fdisk /dev/sdb
List available partitions
Command (m for help): p

Disk identifier: 0xb5ba7975

   Device Boot      Start         End      Blocks   Id  System
Create a boot partition, size 400MiB
Command (m for help):  n
Partition type:
   p   primary (0 primary, 0 extended, 4 free)
   e   extended
Select (default p): p
Partition number (1-4, default 1): 1
First sector (2048-41943039, default 2048):
Using default value 2048
Last sector, +sectors or +size{K,M,G} (2048-41943039, default 41943039): 400M
Value out of range.
Last sector, +sectors or +size{K,M,G} (2048-41943039, default 41943039): +400M
Partition 1 of type Linux and of size 400 MiB is set

Command (m for help): p

Disk /dev/sdb: 21.5 GB, 21474836480 bytes, 41943040 sectors
Units = sectors of 1 * 512 = 512 bytes
Sector size (logical/physical): 512 bytes / 512 bytes
I/O size (minimum/optimal): 512 bytes / 512 bytes
Disk label type: dos
Disk identifier: 0x89cb8c73

   Device Boot      Start         End      Blocks   Id  System
/dev/sdb1            2048      821247      409600   83  Linux
```
Create a SWAP partition, size 1GiB
```
Command (m for help): n
Partition type:
   p   primary (1 primary, 0 extended, 3 free)
   e   extended
Select (default p): p
Partition number (2-4, default 2):
First sector (821248-41943039, default 821248):
Using default value 821248
Last sector, +sectors or +size{K,M,G} (821248-41943039, default 41943039): +1024M
Partition 2 of type Linux and of size 1 GiB is set
Create a data partition, rest of the disk
Command (m for help): n
Partition type:
   p   primary (2 primary, 0 extended, 2 free)
   e   extended
Select (default p): p
Partition number (3,4, default 3):
First sector (2918400-41943039, default 2918400):
Using default value 2918400
Last sector, +sectors or +size{K,M,G} (2918400-41943039, default 41943039):
Using default value 41943039
Partition 3 of type Linux and of size 18.6 GiB is set
```
List all created partitions
```
Command (m for help): p

Disk /dev/sdb: 21.5 GB, 21474836480 bytes, 41943040 sectors
Units = sectors of 1 * 512 = 512 bytes
Sector size (logical/physical): 512 bytes / 512 bytes
I/O size (minimum/optimal): 512 bytes / 512 bytes
Disk label type: dos
Disk identifier: 0x89cb8c73

   Device Boot      Start         End      Blocks   Id  System
/dev/sdb1            2048      821247      409600   83  Linux
/dev/sdb2          821248     2918399     1048576   83  Linux
/dev/sdb3         2918400    41943039    19512320   83  Linux
```
Write changes
```
Command (m for help): w
The partition table has been altered!

Calling ioctl() to re-read partition table.
Syncing disks.
```

### Format disk
Create Ext4 partitions for boot and data
```
sudo mkfs -v -t ext4 /dev/sdb1
sudo mkfs -v -t ext4 /dev/sdb3
```
Create SWAP partition
```
sudo mkswap /dev/sdb2
```

### Set LFS variable
Add LFS to `.bashrc` files
```
export LFS=/mnt/lfs
```

```
vi ~/.bashrc
source ~/.bashrc
sudo vi /root/.bashrc
```

### Mount partitions
```
sudo mkdir -pv $LFS
sudo mount -v -t ext4 /dev/sdb3 $LFS

sudo mkdir -v $LFS/boot
sudo mount -v -t ext4 /dev/sdb1 $LFS/boot
```

### Create source directory
```
mkdir -v $LFS/sources
sudo chmod -v a+wt $LFS/sources
```

### LFS tools
```
mkdir -v $LFS/tools
ln -sv $LFS/tools /
```

### LFS User
```
groupadd lfs
useradd -s /bin/bash -g lfs -m -k /dev/null lfs
passwd lfs
chown -v lfs $LFS/tools
chown -v lfs $LFS/sources
su - lfs
```
